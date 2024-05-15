<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UserCanJoinCompetition.php
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
use Illuminate\Support\Carbon;

class UserCanJoinCompetition implements Rule
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
        return
            $this->competition->slots_taken < $this->competition->slots_max && 
            in_array($this->competition->status, [Competition::STATUS_OPEN, Competition::STATUS_IN_PROGRESS]) && 
            (!$this->competition->end_time || $this->competition->end_time->gte(Carbon::now())); 
    }

    
    public function message()
    {
        return __('app.competition_join_error');
    }
}
