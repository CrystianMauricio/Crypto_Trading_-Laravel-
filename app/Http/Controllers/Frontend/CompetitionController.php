<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CompetitionController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\CloseTrade;
use App\Http\Requests\Frontend\JoinCompetition;
use App\Http\Requests\Frontend\OpenTrade;
use App\Models\Asset;
use App\Models\Competition;
use App\Models\Currency;
use App\Models\Sort\Frontend\CompetitionSort;
use App\Models\Sort\Frontend\CompetitionTradeSort;
use App\Models\Trade;
use App\Services\CompetitionService;
use App\Services\TradeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetitionController extends Controller
{
    private $competitionModel;

    public function __construct(Competition $competition)
    {
        
        
        
        $this->competitionModel = $competition;
    }

    public function index(Request $request)
    {
        $sort = new CompetitionSort($request);

        $competitions = $this->competitionModel::where('status', '!=', Competition::STATUS_CANCELLED)
            ->with('currency')
            ->withCount(['participants as is_participant' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }])
            ->orderBy($sort->getSortColumn(), $sort->getOrder())
            ->paginate($this->rowsPerPage);

        return view('pages.frontend.competitions.index', [
            'competitions'  => $competitions,
            'sort'          => $sort->getSort(),
            'order'         => $sort->getOrder(),
        ]);
    }

    public function show(Request $request, Competition $competition)
    {
        $competitionParticipant = $competition->participant($request->user());
        $redirect = $this->checkAccessOrRedirect($request, $competition, $competitionParticipant);
        if ($redirect)
            return $redirect;

        
        $allowedAssets = $competition->assetsIds();
        $allowedAssetsCount = $allowedAssets->count();

        $currencyRate = config('settings.currency') == 'USD' ? 1 : Currency::where('code', 'USD')->first()->rate;

        $defaultAssetId = $request->session()->get('default_asset_id');
        if (($allowedAssetsCount == 0 && $defaultAssetId) || ($allowedAssetsCount > 0 && $allowedAssets->search($defaultAssetId, TRUE) !== FALSE)) {
            $asset = Asset::find($defaultAssetId);
        } else {
            $asset = Asset::where('status', Asset::STATUS_ACTIVE)->where('price', '>', 0)
                
                ->when($allowedAssetsCount > 0, function($query) use($allowedAssets) {
                    return $query->whereIn('id', $allowedAssets->toArray());
                })
                ->inRandomOrder()
                ->first();
        }

        return view('pages.frontend.competitions.show', [
            'competition'           => $competition,
            'participant'           => $competitionParticipant,
            'asset'                 => $asset,
            'currency_rate'         => $currencyRate,
        ]);
    }

    public function leaderboard(Request $request, Competition $competition)
    {
        $competitionParticipant = $competition->participant($request->user());
        $redirect = $this->checkAccessOrRedirect($request, $competition, $competitionParticipant);
        if ($redirect)
            return $redirect;

        $leaderboard = $competition
            ->participants()
            ->selectRaw('COUNT(trades.id) AS trades_count, IF(MIN(trades.pnl)<0,MIN(trades.pnl),NULL) AS max_loss, IF(MAX(trades.pnl)>0,MAX(trades.pnl),NULL) AS max_profit, SUM(trades.volume*trades.lot_size*trades.price_open) AS total_volume')
            ->leftJoin('trades', function($join) {
                $join->on('competition_participants.user_id', '=', 'trades.user_id');
                $join->on('competition_participants.competition_id', '=', 'trades.competition_id');
            })
            ->groupBy(
                'competition_participants.id',
                'users.id',
                'users.name',
                'users.avatar',
                
                
                'users.email',
                'users.role',
                'users.status',
                'users.password',
                'users.remember_token',
                'users.last_login_time',
                'users.last_login_ip',
                'users.created_at',
                'users.updated_at',
                'users.email_verified_at',
                
                'competition_participants.competition_id',
                'competition_participants.user_id',
                'competition_participants.place',
                'competition_participants.start_balance',
                'competition_participants.current_balance',
                'competition_participants.created_at',
                'competition_participants.updated_at'
            )
            ->orderByRaw('IF(place IS NOT NULL,-1,1), place') 
            ->orderBy('current_balance', 'desc')
            ->orderBy('competition_participants.user_id')
            ->paginate($this->rowsPerPage);

        return view('pages.frontend.competitions.leaderboard', [
            'competition'   => $competition,
            'participant'   => $competitionParticipant,
            'leaderboard'   => $leaderboard,
            'rows_per_page' => $this->rowsPerPage,
        ]);
    }

    public function history(Request $request, Competition $competition)
    {
        $competitionParticipant = $competition->participant($request->user());
        $redirect = $this->checkAccessOrRedirect($request, $competition, $competitionParticipant);
        if ($redirect)
            return $redirect;

        $sort = new CompetitionTradeSort($request);

        $trades = Trade::select('trades.asset_id','trades.direction','trades.volume','trades.price_open','trades.price_close','trades.pnl','trades.created_at','trades.closed_at')
            ->join('assets', 'assets.id', '=', 'trades.asset_id')
            ->where([
                ['competition_id', $competition->id],
                ['user_id', $request->user()->id],
                ['trades.status', Trade::STATUS_CLOSED]
            ])
            ->with('asset:id,symbol,name,logo')
            ->orderBy($sort->getSortColumn(), $sort->getOrder())
            ->paginate($this->rowsPerPage);

        return view('pages.frontend.competitions.history', [
            'competition'   => $competition,
            'participant'   => $competitionParticipant,
            'trades'        => $trades,
            'sort'          => $sort->getSort(),
            'order'         => $sort->getOrder(),
        ]);
    }

    public function join(JoinCompetition $request, Competition $competition)
    {
        $competitionService = new CompetitionService($competition);
        $competitionService->join($request->user());

        return back()->with('success', __('app.competition_join_success', ['title' => $competition->title]));
    }

    
    public function searchAsset(Request $request, Competition $competition, $query) {
        $query = trim(strtolower($query));

        
        $allowedAssets = $competition->assetsIds();

        
        $assets = Asset::where('status', Asset::STATUS_ACTIVE)
            ->where(function($sql) use($query) {
                $sql->whereRaw('LOWER(symbol) LIKE ?', [$query.'%']);
                $sql->orWhereRaw('LOWER(name) LIKE ?', ['%'.$query.'%']);
            })
            
            ->when($allowedAssets->count() > 0, function($query) use($allowedAssets) {
                return $query->whereIn('id', $allowedAssets->toArray());
            })
            ->orderBy('symbol', 'asc') 
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get();

        return [
            'success' => TRUE,
            'results' => $assets
        ];
    }

    
    public function openTrade(OpenTrade $request, Competition $competition, Asset $asset)
    {
        $tradeService = new TradeService($competition, $request->user());
        return $tradeService->open($asset, $request->direction, $request->volume);
    }


    
    public function closeTrade(CloseTrade $request, Competition $competition, Trade $trade)
    {
        $tradeService = new TradeService($competition, $request->user());
        return $tradeService->close($trade);
    }

    public function trades(Request $request, Competition $competition)
    {
        return Trade::where([
            ['competition_id', $competition->id],
            ['user_id', $request->user()->id],
            ['status', Trade::STATUS_OPEN]
        ])
            ->with('asset:id,symbol,name,price,logo')
            ->with('competition:id,leverage')
            ->latest()
            ->get();
    }

    public function participants(Competition $competition) {
        return $competition
            ->participants()
            ->orderBy('place', 'asc')
            ->orderBy('current_balance', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function checkAccessOrRedirect(Request $request, Competition $competition, $competitionParticipant)
    {
        $route = $request->route()->getName();

        if (in_array($competition->status, [Competition::STATUS_OPEN, Competition::STATUS_CANCELLED])) {
            return redirect()->route('frontend.competitions.index')->with('warning', trans_choice('app.competition_waiting_participants', $competition->slots_required - $competition->slots_taken, ['n' => $competition->slots_required - $competition->slots_taken]));
            
        } elseif (!$competitionParticipant && $route != 'frontend.competitions.leaderboard') {
            return redirect()->route('frontend.competitions.leaderboard', $competition);
        } elseif ($competition->status == Competition::STATUS_COMPLETED && $route == 'frontend.competitions.show') {
            return redirect()->route('frontend.competitions.leaderboard', $competition);
        }

        return NULL;
    }
}
