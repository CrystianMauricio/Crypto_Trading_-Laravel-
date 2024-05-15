<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CheckSocialProvider.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Middleware;

use Closure;

class CheckSocialProvider
{
    
    public function handle($request, Closure $next)
    {
        if (!config('services.'.$request->provider.'.client_id')
            || !config('services.'.$request->provider.'.client_secret')
            || !config('services.'.$request->provider.'.redirect')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
