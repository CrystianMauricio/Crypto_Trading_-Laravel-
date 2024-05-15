<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CoinCapApi.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services\API;

class CoinCapApi extends API
{
    protected $baseUri = 'https://api.coincap.io/v2/';

    public function quote($id) {
        return $this->getJson('assets/' . $id . '?', $this->getRequestOptions());
    }

    public function quotes() {
        return $this->getJson('assets?limit=2000', $this->getRequestOptions());
    }

    protected function getRequestOptions(): array
    {
        if (config('settings.coincap_api_key')) {
            return [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('settings.coincap_api_key')
                ]
            ];
        }

        return [];
    }
}
