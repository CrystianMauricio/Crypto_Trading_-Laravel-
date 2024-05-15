<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   RegisterController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use App\Rules\ReCaptchaValidationPassed;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    

    use RegistersUsers;

    
    protected $redirectTo = RouteServiceProvider::HOME;

    
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('cookie-consent');
    }

    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'min:3', 'max:100', 'unique:users'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => config('settings.recaptcha.secret_key') ? ['required', new ReCaptchaValidationPassed()] : [],
        ], ['g-recaptcha-response.required' => __('auth.human')]);
    }

    
    protected function create(array $data)
    {
        return User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'role'              => User::ROLE_USER,
            'status'            => User::STATUS_ACTIVE,
            'last_login_time'   => Carbon::now(),
            'last_login_ip'     => request()->ip(),
            'password'          => Hash::make($data['password']),
        ]);
    }

    
    protected function registered(Request $request, $user)
    {
        if (config('settings.users.email_verification')) {
            return redirect($this->redirectPath())->with('success', __('auth.email_verification_notice'));
        }

        return FALSE;
    }
}
