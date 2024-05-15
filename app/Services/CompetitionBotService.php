<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CompetitionBotService.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services;

use App\Models\Asset;
use App\Models\Competition;
use App\Models\User;
use Carbon\Carbon;

class CompetitionBotService
{
    public function run()
    {
        
        Competition::where('status', Competition::STATUS_IN_PROGRESS)->get()->each(function($competition, $i) {
            $allowedAssets = $competition->assetsIds();

            
            $topAssets = Asset::where('status', Asset::STATUS_ACTIVE)
                ->where('price','>',0)
                
                ->when($allowedAssets->count() == 0, function($query) {
                    return $query->orderBy('market_cap','desc')->limit(config('settings.bots.top_assets_limit'));
                })
                
                ->when($allowedAssets->count() > 0, function($query) use($allowedAssets) {
                    return $query->whereIn('id', $allowedAssets->toArray());
                })
                ->get();

            
            $competition->participants()->inRandomOrder()->where('role', User::ROLE_BOT)->get()->each(function($bot) use($competition, $topAssets) {
                $tradeService = new TradeService($competition, $bot);
                
                $tradesToOpenCount = mt_rand(config('settings.bots.min_trades_to_open'), config('settings.bots.max_trades_to_open'));

                for ($i = 0; $i < $tradesToOpenCount; $i++) {
                    
                    if ($i > 0)
                        $tradeService->loadOpenTrades();

                    $asset = $topAssets->random(); 
                    $direction = mt_rand(0, 1); 
                    $maxVolume = $tradeService->freeMargin() * $competition->leverage / $asset->price * $competition->lot_size;

                    

                    if ($maxVolume < $competition->volume_min)
                        continue;

                    $volume = mt_rand($competition->volume_min * 100, min($competition->volume_max, $maxVolume) * 100) / 100; 

                    if ($tradeService->margin($asset, $volume) > 99999999)
                        continue;

                    
                    $tradeService->open($asset, $direction, $volume);
                }

                
                $earliestDate = Carbon::now()->subSeconds(config('settings.bots.min_trade_life_time'));
                
                $tradesToCloseCount = mt_rand(config('settings.bots.min_trades_to_close'), config('settings.bots.max_trades_to_close'));
                $competition->openTrades()->where('user_id', $bot->id)->where('created_at','<',$earliestDate)->limit($tradesToCloseCount)->get()->each(function($trade) use($tradeService) {
                    $tradeService->close($trade);
                });
            });
        });
    }
}
