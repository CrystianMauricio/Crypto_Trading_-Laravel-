<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   PageController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Frontend;

use App\Models\Trade;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    public function index() {
        $recentTrades = Trade::with('asset', 'currency')->orderBy('trades.id', 'desc')->limit(5)->get();
        return view('pages.frontend.index', ['recent_trades' => $recentTrades]);
    }

    public function help() {
        return view('pages.frontend.help');
    }

    
    public function display($slug)
    {
        return view()->exists('pages.frontend.static.' . $slug . '-udf') 
            ? view('pages.frontend.static.' . $slug . '-udf')
            : (view()->exists('pages.frontend.static.' . $slug)
                ? view('pages.frontend.static.' . $slug)
                : abort(404));
    }

    public function acceptCookies() {
        Cookie::queue(Cookie::make('cookie_usage_accepted', 1, 525600)); 
        return ['success' => TRUE];
    }
}
