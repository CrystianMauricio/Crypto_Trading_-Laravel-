<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   Locale.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Middleware;

use App\Services\LocaleService;
use Closure;
use Illuminate\Support\Facades\View;

class Locale
{
    
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        } else {
            $locale = config('app.locale');
            $request->session()->put('locale', $locale);
        }

        app()->setLocale($locale);

        View::share('locale', new LocaleService());

        return $next($request);
    }
}
