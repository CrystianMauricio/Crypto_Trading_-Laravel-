<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UserCanCloseTrade.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Rules;

use App\Models\Competition;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserCanCloseTrade implements Rule
{
    private $trade;
    private $competition;
    private $user;
    
    public function __construct(Trade $trade, Competition $competition, User $user)
    {
        $this->trade = $trade;
        $this->competition = $competition;
        $this->user = $user;
    }

    
    public function passes($attribute, $value)
    {
        return $this->trade->competition_id == $this->competition->id
            && $this->trade->user_id == $this->user->id
            && $this->trade->status == Trade::STATUS_OPEN;
    }

    
    public function message()
    {
        return __('app.can_not_close_trade');
    }
}
