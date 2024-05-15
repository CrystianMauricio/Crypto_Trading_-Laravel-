<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CompetitionIsEditable.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Rules;

use App\Models\Competition;
use Illuminate\Contracts\Validation\Rule;

class CompetitionIsEditable implements Rule
{
    private $competition;
    
    public function __construct(Competition $competition)
    {
        $this->competition = $competition;
    }

    
    public function passes($attribute = NULL, $value = NULL)
    {
        return !in_array($this->competition->status, [Competition::STATUS_CANCELLED, Competition::STATUS_COMPLETED]);
    }

    
    public function message()
    {
        return __('app.competition_edit_warning');
    }
}
