<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   channels.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

use Illuminate\Support\Facades\Broadcast;



Broadcast::channel('chat', function ($user) {
    return [
        'id'    => $user->id,
        'name'  => $user->name,
    ];
});
