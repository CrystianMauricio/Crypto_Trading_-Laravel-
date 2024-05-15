<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UserPointService.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services;

use App\Models\User;
use App\Models\UserPoint;

class UserPointService
{
    
    public function add(User $user, $type, $points) {
        if ($points > 0) {
            $userPoint = new UserPoint();
            $userPoint->user()->associate($user);
            $userPoint->type = $type;
            $userPoint->points = $points;
            $userPoint->save();
            return $userPoint;
        }

        return NULL;
    }
}