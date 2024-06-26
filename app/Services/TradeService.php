<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   TradeService.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services;

use App\Events\AfterTradeClosed;
use App\Models\Asset;
use App\Models\Competition;
use App\Models\Currency;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TradeService extends Service
{
    private $competition;
    private $user;
    private $openTrades;

    public function __construct(Competition $competition, User $user)
    {
        $this->competition = $competition;
        $this->user = $user;
    }

    
    public function open(Asset $asset, $direction, $volume) {
        $assetService = new AssetService();
        $price = $assetService->asset($asset)->price;

        Log::info(sprintf('New trade by user %d: %s %d x %.2f %s @ %f', $this->user->id, ($direction==Trade::DIRECTION_BUY?'buy':'sell'), $this->competition->lot_size, $volume, $asset->external_id, $price));

        
        $trade = new Trade();
        $trade->competition()->associate($this->competition);
        $trade->user()->associate($this->user);
        $trade->asset()->associate($asset);
        $trade->currency()->associate($this->competition->currency);
        $trade->direction   = $direction;
        $trade->lot_size    = $this->competition->lot_size;
        $trade->volume      = $volume;
        $trade->price_open  = $price;
        $trade->margin      = $this->margin($asset, $volume);
        $trade->status      = Trade::STATUS_OPEN;
        $trade->save();

        return $trade;
    }

    public function close(Trade $trade) {
        if ($trade->status == Trade::STATUS_OPEN) {
            $assetService = new AssetService();
            $price = $assetService->asset($trade->asset)->price;

            Log::info(sprintf('Close trade %d by user %d @ %f', $trade->id, $this->user->id, $price));

            $trade->price_close = $price;
            $trade->pnl = $this->unrealizedProfitLoss($trade);
            $trade->status = Trade::STATUS_CLOSED;
            $trade->closed_at = Carbon::now();
            $trade->save();

            
            $this->competition->participant($trade->user)->data->increment('current_balance', $trade->pnl);

            event(new AfterTradeClosed($trade));
        }

        return $trade;
    }

    
    public function closeAll() {
        Log::info(sprintf('Closing all trades of user %d', $this->user->id));

        foreach ($this->openTrades() as $openTrade) {
            $this->close($openTrade);
        }
    }

    
    public function margin(Asset $asset, $volume) {
        return $this->competition->leverage
            ? $asset->price * $this->competition->lot_size * $volume / $this->competition->leverage
            : 0;
    }

    
    public function balance() {
        $participant = $this->competition->participant($this->user);
        if (!$participant)
            abort(404);

        return $participant->data->current_balance;
    }

    
    public function totalMargin() {
        $totalMargin = 0;
        foreach ($this->openTrades() as $trade) {
            $totalMargin += $trade->margin;
        }
        return $totalMargin;
    }

    
    public function unrealizedProfitLoss(Trade $trade) {
        
        return isset($trade->unrealizedPnl)
            ? $trade->unrealizedPnl
            : ($trade->asset->price - $trade->price_open) * $trade->direction_sign * $trade->lot_size * $trade->volume;
    }

    
    public function totalUnrealizedProfitLoss() {
        $totalUnrealizedPnl = 0;
        foreach ($this->openTrades() as $trade) {
            
            $trade->unrealizedPnl = $this->unrealizedProfitLoss($trade);
            $totalUnrealizedPnl += $trade->unrealizedPnl;
        }
        return $totalUnrealizedPnl;
    }

    
    public function equity() {
        return $this->balance() + $this->totalUnrealizedProfitLoss();
    }

    
    public function freeMargin() {
        return $this->equity() - $this->totalMargin();
    }

    
    public function marginLevel() {
        if ($this->openTrades()->isEmpty())
            throw new \Exception('Margin level can not be calculated if the user does not have open trades.');

        return $this->totalMargin() != 0 ? $this->equity() / $this->totalMargin() * 100 : 100;
    }

    
    public function openTrades() {
        if (is_null($this->openTrades))
            $this->loadOpenTrades();

        return $this->openTrades;
    }

    public function closedTradesCount() {
        return Trade::where([
            ['competition_id',  $this->competition->id],
            ['user_id',         $this->user->id],
            ['status',          Trade::STATUS_CLOSED]
        ])
            ->count();
    }

    
    public function loadOpenTrades() {
        $this->openTrades = Trade::where([
            ['competition_id',  $this->competition->id],
            ['user_id',         $this->user->id],
            ['status',          Trade::STATUS_OPEN]
        ])
            ->with('asset')
            ->get();
    }
}
