<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UserIsNotParticipant.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Rules;

use App\Models\Competition;
use App\Models\CompetitionParticipant;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserIsNotParticipant implements Rule
{
    private $competition;
    private $user;

    
    public function __construct(Competition $competition, User $user)
    {
        $this->competition = $competition;
        $this->user = $user;
    }

    
    public function passes($attribute = NULL, $value = NULL)
    {
        return $this->competition->participant($this->user) == NULL;
    }

    
    public function message()
    {
        return __('app.you_are_participant');
    }
}
