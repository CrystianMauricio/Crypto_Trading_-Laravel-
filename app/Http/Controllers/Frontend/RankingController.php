<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   RankingController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Http\Controllers\Controller;

class RankingController extends Controller
{
    public function index() {
        $users = User::selectRaw('users.id, name, avatar, IFNULL(SUM(points),0) AS points')
            ->where('status', User::STATUS_ACTIVE)
            ->leftJoin('user_points', 'user_points.user_id', '=', 'users.id')
            ->withCount(['closedTrades as profitable_trades_count' => function ($query) {
                $query->where('pnl', '>', 0);
            }])
            ->withCount(['closedTrades as unprofitable_trades_count' => function ($query) {
                $query->where('pnl', '<=', 0);
            }])
            ->groupBy('users.id','name','avatar')
            ->orderBy('points', 'desc')
            ->orderBy('id', 'asc')
            ->paginate($this->rowsPerPage);

        return view('pages.frontend.rankings', [
            'users' => $users
        ]);
    }
}
