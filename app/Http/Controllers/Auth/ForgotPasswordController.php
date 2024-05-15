<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   ForgotPasswordController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\ReCaptchaValidationPassed;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    

    use SendsPasswordResetEmails;

    
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    
    protected function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'g-recaptcha-response' => config('settings.recaptcha.secret_key') ? ['required', new ReCaptchaValidationPassed()] : [],
        ], ['g-recaptcha-response.required' => __('auth.human')]);
    }


    
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        
        
        
        $credentials = array_merge($request->only('email'), ['status' => User::STATUS_ACTIVE]);
        $response = $this->broker()->sendResetLink($credentials);

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }
}
