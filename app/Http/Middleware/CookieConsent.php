<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CookieConsent.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class CookieConsent
{
    
    public function handle($request, Closure $next)
    {
        View::share('cookie_usage_accepted', Cookie::get('cookie_usage_accepted')?:0);

        return $next($request);
    }
}
