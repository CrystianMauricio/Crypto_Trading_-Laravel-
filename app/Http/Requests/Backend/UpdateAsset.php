<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UpdateAsset.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Requests\Backend;

use App\Models\Asset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAsset extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'symbol'        => 'required|string|max:30|unique:assets,symbol,' . $this->asset->id . ',id', 
            'external_id'   => 'required|string|max:100|unique:assets,external_id,' . $this->asset->id . ',id', 
            'name'          => 'required|string|max:150',
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price'         => 'required|numeric|min:0|max:999999999999.99999999',
            'change_abs'    => 'required|numeric|min:-999999999999.99999999|max:999999999999.99999999',
            'change_pct'    => 'required|numeric|min:-9999999999.99|max:9999999999.99',
            'volume'        => 'required|numeric|min:0|max:9223372036854775807', 
            'supply'        => 'required|numeric|min:0|max:9223372036854775807', 
            'market_cap'    => 'required|numeric|min:0|max:9223372036854775807', 
            'status' => [
                'required',
                Rule::in(Asset::getStatuses()),
            ],
        ];
    }
}
