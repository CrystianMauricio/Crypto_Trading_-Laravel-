<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   BroadcastServiceProvider.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
