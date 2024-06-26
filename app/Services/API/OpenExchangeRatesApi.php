<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   OpenExchangeRatesApi.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services\API;


class OpenExchangeRatesApi extends API
{
    protected $baseUri = 'https://openexchangerates.org/api/';
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        parent::__construct();
    }

    public function latest()
    {
        return $this->getJson('latest.json?app_id=' . $this->apiKey)->rates;
    }
}