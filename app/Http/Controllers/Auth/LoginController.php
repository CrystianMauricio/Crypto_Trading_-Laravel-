<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   LoginController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\ReCaptchaValidationPassed;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    

    use AuthenticatesUsers;

    
    protected $redirectTo = RouteServiceProvider::HOME;

    
    public function __construct()
    {
        $this->middleware(['guest','cookie-consent'])->except('logout');
    }

    
    protected function validateLogin(Request $request)
    {
        error_log("xxxxxxxxxxxxxxxxxxxx => ".$this->username());
        $request->validate([
            $this->username()           => 'required|string',
            'password'                  => 'required|string',
            'g-recaptcha-response'      => config('settings.recaptcha.secret_key') ? ['required', new ReCaptchaValidationPassed()] : [],
        ], ['g-recaptcha-response.required' => __('auth.human')]);
    }

    
    protected function credentials(Request $request)
    {
        
        return array_merge($request->only($this->username(), 'password'), ['status' => User::STATUS_ACTIVE]);
    }

    
    protected function authenticated(Request $request, $user)
    {
        $user->last_login_time = Carbon::now();
        $user->last_login_ip = $request->ip();
        $user->save();
    }
}
