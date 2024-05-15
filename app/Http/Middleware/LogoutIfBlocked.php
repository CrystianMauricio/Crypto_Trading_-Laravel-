<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   LogoutIfBlocked.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class LogoutIfBlocked
{
    
    public function handle($request, Closure $next)
    {
        
        if ($request->user()->status != User::STATUS_ACTIVE) {
            auth()->logout();
            return redirect()->route('login')->with('error', __('auth.blocked'));
        }

        return $next($request);
    }
}
