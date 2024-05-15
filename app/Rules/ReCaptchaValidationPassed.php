<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   ReCaptchaValidationPassed.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ReCaptchaValidationPassed implements Rule
{
    
    public function __construct()
    {
        
    }

    
    public function passes($attribute, $value)
    {
        $reCaptchaSecretKey = config('settings.recaptcha.secret_key');
        
        if (!$reCaptchaSecretKey)
            return TRUE;

        
        $client = new Client([
            'base_uri' => 'https://google.com/recaptcha/api/'
        ]);
        $response = $client->post('siteverify', [
            'query' => [
                'secret'    => $reCaptchaSecretKey,
                'response'  => $value,
                'remoteip'  => request()->ip(),
            ]
        ]);

        Log::info($response->getBody());

        $responseBody = json_decode($response->getBody());

        return $responseBody->success ?? FALSE;
    }

    
    public function message()
    {
        return __('Please verify that you are a human.');
    }
}
