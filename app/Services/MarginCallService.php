<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   MarginCallService.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services;

use App\Models\Competition;
use App\Notifications\MailMarginCall;
use Illuminate\Support\Facades\Log;

class MarginCallService
{
    public function run() {
        $openCompetitions = Competition::where('status', Competition::STATUS_IN_PROGRESS)->get();

        foreach ($openCompetitions as $openCompetition) {
            foreach ($openCompetition->participants()->get() as $participant) {
                $tradeService = new TradeService($openCompetition, $participant);

                
                $openTrades = $tradeService->openTrades();
                if (!$openTrades->isEmpty()) {
                    $marginLevel = $tradeService->marginLevel();

                    
                    if ($marginLevel < $openCompetition->min_margin_level) {
                        
                        $mostLosingTrade = $openTrades->sortBy('unrealizedPnl')->first();
                        Log::debug(sprintf('Competition %s, User %d, Margin level: %.2f (min %.2f), Close trade: %d', $openCompetition->id, $participant->id, $marginLevel, $openCompetition->min_margin_level, $mostLosingTrade->id));
                        
                        $tradeService->close($mostLosingTrade);
                        
                        if (!$participant->bot())
                            $participant->notify(new MailMarginCall($openCompetition, $mostLosingTrade));
                    }
                }
            }
        }
    }
}