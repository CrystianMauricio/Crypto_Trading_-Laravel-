<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CheckEmailIsVerified.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class CheckEmailIsVerified
{
    
    public function handle($request, Closure $next)
    {
        
        if (config('settings.users.email_verification') && !$request->user()->hasVerifiedEmail()) {
            return $request->expectsJson()
                ? response()->json(['error' => __('Please verify your email address.')])
                : Redirect::route('verification.notice');
        }

        return $next($request);
    }
}
