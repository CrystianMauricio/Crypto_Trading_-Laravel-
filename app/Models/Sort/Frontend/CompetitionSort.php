<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CompetitionSort.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Sort\Frontend;

use App\Models\Sort\Sort;

class CompetitionSort extends Sort
{
    protected $sortableColumns = [
        'id'                => 'id',
        'title'             => 'title',
        'balance'           => 'start_balance',
        'duration'          => 'duration',
        'slots'             => 'slots_taken',
        'status'            => 'status',
        'created'           => 'created_at',
    ];
}