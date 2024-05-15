<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CloseTrade.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Requests\Frontend;

use App\Rules\AssetPriceIsValid;
use App\Rules\CompetitionIsInProgress;
use App\Rules\UserCanCloseTrade;
use Illuminate\Foundation\Http\FormRequest;

class CloseTrade extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            '*' => [
                new AssetPriceIsValid($this->trade->asset),
                new CompetitionIsInProgress($this->competition),
                new UserCanCloseTrade($this->trade, $this->competition, $this->user())
            ],
        ];
    }
}
