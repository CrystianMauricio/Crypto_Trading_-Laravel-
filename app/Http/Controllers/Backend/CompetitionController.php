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

namespace App\Http\Controllers\Backend;

use App\Models\Currency;
use App\Http\Requests\Backend\StoreCompetition;
use App\Http\Requests\Backend\UpdateCompetition;
use App\Models\Competition;
use App\Models\Sort\Backend\CompetitionSort;
use App\Rules\CompetitionIsEditable;
use App\Services\CompetitionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompetitionController extends Controller
{
    
    public function index(Request $request, Competition $competition)
    {
        $sort = new CompetitionSort($request);

        $competitions = Competition::orderBy($sort->getSortColumn(), $sort->getOrder())
            ->with('currency')
            ->paginate($this->rowsPerPage);

        return view('pages.backend.competitions.index', [
            'competitions'  => $competitions,
            'sort'          => $sort->getSort(),
            'order'         => $sort->getOrder(),
        ]);
    }

    
    public function create()
    {
        return view('pages.backend.competitions.create', ['durations' => Competition::getEnumValues('CompetitionDuration')]);
    }

    
    public function store(StoreCompetition $request)
    {
        
        $currency = Currency::where('code', config('settings.currency'))->first();

        
        $competition = new Competition();
        $competition->title = $request->title;
        $competition->duration = $request->duration;
        $competition->slots_required = $request->slots_required;
        $competition->slots_max = $request->slots_max;
        $competition->start_balance = $request->start_balance;
        $competition->lot_size = $request->lot_size;
        $competition->leverage = $request->leverage;
        $competition->volume_min = $request->volume_min;
        $competition->volume_max = $request->volume_max;
        $competition->min_margin_level = $request->min_margin_level;
        $competition->fee = $request->fee ?: 0;
        $competition->status = Competition::STATUS_OPEN;
        $competition->recurring = $request->recurring == 'on' ? TRUE : FALSE;
        $competition->user()->associate($request->user());
        $competition->currency()->associate($currency);

        
        if (is_array($request->payouts_amounts) && is_array($request->payouts_types)) {
            $payoutStructure = array_map(function($payout, $type) {
                return [
                    'amount'    => $payout,
                    'type'      => $type
                ];
            }, $request->payouts_amounts, $request->payouts_types);
            $competition->payout_structure = serialize($payoutStructure);
        }

        $competition->save();

        
        if ($request->assets)
            $competition->assets()->attach(explode(',', $request->assets));

        return redirect()
            ->route('backend.competitions.index')
            ->with('success', __('app.create_competition_success', ['title' => $competition->title]));
    }

    
    public function edit(Request $request, Competition $competition)
    {
        $view = view('pages.backend.competitions.edit', [
            'competition'       => $competition,
            'payouts_amounts'   => array_column($competition->payouts, 'amount'),
            'payouts_types'     => array_column($competition->payouts, 'type'),
            'durations'         => Competition::getEnumValues('CompetitionDuration'),
            'editable'          => (new CompetitionIsEditable($competition))->passes()
        ]);

        
        if (!$view->editable)
            $request->session()->flash('warning', __('app.competition_edit_warning'));

        return $view;
    }

    
    public function update(UpdateCompetition $request, Competition $competition)
    {
        $competition->title = $request->title;

        $competition->slots_required = $request->slots_required;
        $competition->slots_max = $request->slots_max;
        $competition->start_balance = $request->start_balance;
        $competition->lot_size = $request->lot_size;
        $competition->leverage = $request->leverage;
        $competition->volume_min = $request->volume_min;
        $competition->volume_max = $request->volume_max;
        $competition->min_margin_level = $request->min_margin_level;
        $competition->fee = $request->fee ?: 0;
        $competition->status = $request->status;
        $competition->recurring = $request->recurring == 'on' ? TRUE : FALSE;

        
        if (is_array($request->payouts_amounts) && is_array($request->payouts_types)) {
            $payoutStructure = array_map(function($payout, $type) {
                return [
                    'amount'    => $payout,
                    'type'      => $type
                ];
            }, $request->payouts_amounts, $request->payouts_types);
            $competition->payout_structure = serialize($payoutStructure);
        } else {
            $competition->payout_structure = NULL;
        }

        $competition->save();

        
        $assetsIds = $request->assets ? explode(',', $request->assets) : [];
        $competition->assets()->sync($assetsIds);

        return redirect()
            ->route('backend.competitions.index')
            ->with('success', __('app.competition_saved', ['name' => $competition->title]));
    }

    
    public function delete(Request $request, Competition $competition) {
        $request->session()->flash('warning', __('app.competition_delete_warning'));
        return view('pages.backend.competitions.delete', ['competition' => $competition]);
    }

    
    public function destroy(Competition $competition)
    {
        $competitionTitle = $competition->title;
        $competition->delete();

        return redirect()
            ->route('backend.competitions.index')
            ->with('success', __('app.competition_deleted', ['name' => $competitionTitle]));
    }

    
    public function duplicate(Request $request, Competition $competition)
    {
        $competitionService = new CompetitionService($competition);
        $competitionService->clone();

        return redirect()
            ->route('backend.competitions.index')
            ->with('success', __('app.competition_cloned', ['name' => $competition->title]));
    }

    public function addBotsForm(Competition $competition)
    {
        return view('pages.backend.competitions.add-bots', [
            'competition'  => $competition,
        ]);
    }

    public function addBots(Request $request, Competition $competition)
    {
        $n = intval($request->n);
        if ($n <= 0)
            return back()->withInput()->withErrors(__('validation.integer', ['attribute' => __('app.bots_count')]));

        $competitionService = new CompetitionService($competition);
        $competitionService->addBots($n);

        return redirect()->route('backend.competitions.index')->with('success', __('app.operation_completed'));
    }

    public function removeBotsForm(Competition $competition)
    {
        return view('pages.backend.competitions.remove-bots', [
            'competition'  => $competition,
        ]);
    }

    public function removeBots(Request $request, Competition $competition)
    {
        $n = intval($request->n);
        if ($n <= 0)
            return back()->withInput()->withErrors(__('validation.integer', ['attribute' => __('app.bots_count')]));

        $competitionService = new CompetitionService($competition);
        $competitionService->removeBots($n);

        return redirect()->route('backend.competitions.index')->with('success', __('app.operation_completed'));
    }
}