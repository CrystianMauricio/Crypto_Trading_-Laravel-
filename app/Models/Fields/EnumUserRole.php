<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   EnumUserRole.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Fields;

interface EnumUserRole {
    const ROLE_USER     = 'USER';
    const ROLE_ADMIN    = 'ADMIN';
    const ROLE_BOT      = 'BOT';
}