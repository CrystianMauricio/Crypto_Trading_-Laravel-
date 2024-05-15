<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CheckRole.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()->hasRole($role)) {
            return redirect()->route('frontend.index');
        }

        return $next($request);
    }
}
