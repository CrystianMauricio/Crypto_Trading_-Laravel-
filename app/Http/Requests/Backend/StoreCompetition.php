<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   StoreCompetition.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreCompetition extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules(Request $request)
    {
        return [
            'title'             => 'required|string|max:150',
            'duration'          => [
                'required',
                'string',
                'max:30',
                'regex:/[0-9PTYMDHS]+/'
            ],
            'slots_required'    => 'required|integer|min:1|max:16777215', 
            'slots_max'         => 'required|integer|min:'.$request->slots_required.'|max:16777215', 
            'start_balance'     => 'required|numeric|min:0.01|max:9999999999.99',
            'lot_size'          => 'required|integer|min:1',
            'leverage'          => 'required|integer|min:1',
            'volume_min'        => 'required|numeric|min:0.01',
            'volume_max'        => 'required|numeric|min:'.$request->volume_min.'|max:999999',
            'min_margin_level'  => 'required|numeric|min:0|max:9999.99',
            'fee'               => 'sometimes|required|numeric|min:0|max:999999999999.99',
        ];
    }
}
