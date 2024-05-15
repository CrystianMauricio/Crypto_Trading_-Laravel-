<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   Kernel.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Console;

use App\Console\Commands\CheckMarginLevel;
use App\Console\Commands\CloseCompetitions;
use App\Console\Commands\UpdateAssetsMarketData;
use App\Console\Commands\UpdateCurrenciesMarketData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        UpdateAssetsMarketData::class,
        UpdateCurrenciesMarketData::class,
        CheckMarginLevel::class,
        CloseCompetitions::class,
    ];

    
    protected function schedule(Schedule $schedule): void
    {
        
        $schedule->command('asset:update')->everyFiveMinutes();
        $schedule->command('currency:update')->hourly();
        $schedule->command('competition:check-margin')->everyFiveMinutes();
        $schedule->command('competition:close')->everyMinute();
        $schedule->command('generate:trades')->everyFiveMinutes();
    }

    
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
