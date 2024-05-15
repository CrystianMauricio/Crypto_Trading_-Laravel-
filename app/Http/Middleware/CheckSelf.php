<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CheckSelf.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Middleware;

use Closure;

class CheckSelf
{
    
    public function handle($request, Closure $next)
    {
        
        
        if ($request->user()->id != $request->user->id) {
            return redirect()->route('frontend.index');
        }

        return $next($request);
    }
}
