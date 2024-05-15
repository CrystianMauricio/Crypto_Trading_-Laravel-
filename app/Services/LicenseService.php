<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   LicenseService.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services;

use GuzzleHttp\Client;

class LicenseService
{
    
    public function register($code, $email, $hash = NULL)
    {
        try {
            $client = new Client(['base_uri' => config('app.api.products.base_uri')]);

            $response = $client->request('POST', 'licenses/register', [
                'form_params' => [
                    'code' => $code,
                    'email' => $email,
                    'domain' => request()->getHost(),
                    'hash' => $hash ?: config('app.hash')
                ]
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (\Throwable $e) {
            return (object) ['success' => FALSE, 'message' => $e->getMessage()];
        }
    }
}
