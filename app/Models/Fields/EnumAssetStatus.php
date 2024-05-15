<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   EnumAssetStatus.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Fields;

interface EnumAssetStatus {
    const STATUS_ACTIVE     = 0;
    const STATUS_BLOCKED    = 1;
}