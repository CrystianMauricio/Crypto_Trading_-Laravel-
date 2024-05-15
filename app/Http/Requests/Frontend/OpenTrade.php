<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   OpenTrade.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Requests\Frontend;

use App\Models\Trade;
use App\Rules\AssetCanBeTraded;
use App\Rules\FreeMarginIsSufficient;
use App\Rules\CompetitionIsInProgress;
use Illuminate\Foundation\Http\FormRequest;

class OpenTrade extends FormRequest
{
    private $competitionParticipant;

    
    public function authorize()
    {
        return TRUE;
    }

    
    public function rules()
    {
        return [
            'volume'        => 'required|numeric|min:'.$this->competition->volume_min.'|max:'.$this->competition->volume_max,
            'direction'     => 'required|integer|in:' . implode(',', [Trade::DIRECTION_BUY, Trade::DIRECTION_SELL]),
            '*'             => [
                new AssetCanBeTraded($this->competition, $this->asset),
                new CompetitionIsInProgress($this->competition),
                new FreeMarginIsSufficient(
                    $this->asset,
                    $this->competition,
                    $this->user(),
                    $this->volume
                ),
            ],
        ];
    }
}