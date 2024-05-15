<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   EnumCompetitionStatus.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Fields;

interface EnumCompetitionStatus {
    const STATUS_OPEN           = 0;
    const STATUS_IN_PROGRESS    = 1;
    const STATUS_COMPLETED      = 2;
    const STATUS_CANCELLED      = 3;
}