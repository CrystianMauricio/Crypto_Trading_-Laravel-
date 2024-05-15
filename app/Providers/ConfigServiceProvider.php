<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   ConfigServiceProvider.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        
    }

    
    public function register()
    {
        
        
        foreach (['facebook','google','twitter','linkedin'] as $provider) {
            config([
                'services.'.$provider.'.redirect' => url(config('services.'.$provider.'.redirect')),
            ]);
        }
    }
}