<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UpdateCurrenciesMarketData.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Console\Commands;

use App\Services\CurrencyService;
use Illuminate\Console\Command;

class UpdateCurrenciesMarketData extends Command
{
    
    protected $signature = 'currency:update';

    
    protected $description = 'Pull current currencies rates data from API and persist it to the database.';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle(CurrencyService $currencyService)
    {
        $currencyService->bulkUpdateMarketData();

        return 0;
    }
}
