<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UserSort.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Sort\Backend;

use App\Models\Sort\Sort;

class UserSort extends Sort
{
    protected $sortableColumns = [
        'id'                => 'id',
        'name'              => 'name',
        'email'             => 'email',
        'status'            => 'status',
        'last_login_time'   => 'last_login_time',
    ];
}