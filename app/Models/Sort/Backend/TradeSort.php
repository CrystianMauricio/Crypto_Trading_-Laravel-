<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   TradeSort.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Sort\Backend;

use App\Models\Sort\Sort;

class TradeSort extends Sort
{
    protected $sortableColumns = [
        'id'                => 'trades.id',
        'competition'       => 'competitions.title',
        'asset'             => 'assets.symbol',
        'direction'         => 'direction',
        'lot'               => 'lot_size',
        'volume'            => 'volume',
        'price_open'        => 'price_open',
        'price_close'       => 'price_close',
        'margin'            => 'margin',
        'pnl'               => 'pnl',
        'created'           => 'created_at',
    ];
}