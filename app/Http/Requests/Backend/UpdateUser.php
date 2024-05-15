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

namespace App\Http\Requests\Backend;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'password'      => 'nullable|string|min:8',
            'role' => [
                'required',
                Rule::in(User::getRoles()),
            ],
            'status' => [
                'required',
                Rule::in(User::getStatuses()),
            ],
        ];
    }
}
