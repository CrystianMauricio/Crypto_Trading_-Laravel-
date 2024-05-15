<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UpdateUser.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        
        
        return [
            'name'          => 'required|string|max:100|unique:users,name,' . $this->user->id . ',id', 
            'email'         => 'required|string|email|max:255|unique:users,email,' . $this->user->id . ',id', 
            'avatar'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
