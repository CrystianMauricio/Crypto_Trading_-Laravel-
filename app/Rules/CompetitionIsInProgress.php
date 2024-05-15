<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CompetitionIsInProgress.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Rules;

use App\Models\Competition;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;

class CompetitionIsInProgress implements Rule
{
    private $competition;

    
    public function __construct(Competition $competition)
    {
        $this->competition = $competition;
    }

    
    public function passes($attribute, $value)
    {
        $now = Carbon::now();
        return $this->competition->status == Competition::STATUS_IN_PROGRESS
            && $this->competition->start_time 
            && $this->competition->end_time 
            && $this->competition->start_time->lte($now)
            && $this->competition->end_time->gte($now);
    }

    
    public function message()
    {
        return __('app.competition_not_in_progress');
    }
}
