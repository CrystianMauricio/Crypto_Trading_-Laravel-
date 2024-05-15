<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   JoinCompetition.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Requests\Frontend;

use App\Rules\UserCanJoinCompetition;
use App\Rules\UserIsNotParticipant;
use Illuminate\Foundation\Http\FormRequest;

class JoinCompetition extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        $rules = [
            '*' => [
                new UserIsNotParticipant($this->competition, $this->user()),
                new UserCanJoinCompetition($this->competition, $this->user()),
            ]
        ];

        return $rules;
    }
}
