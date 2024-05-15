<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   EnumTradeStatus.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Fields;

interface EnumTradeStatus {
    const STATUS_OPEN       = 0;
    const STATUS_CLOSED     = 1;
    const STATUS_CANCELLED  = 2;
}