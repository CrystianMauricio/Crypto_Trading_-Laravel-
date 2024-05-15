<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UpdateAssetsMarketData.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Console\Commands;

use App\Services\AssetService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateAssetsMarketData extends Command
{
    
    protected $signature = 'asset:update';

    
    protected $description = 'Pull current assets quotes data from API and persist it to the database.';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle(AssetService $assetService)
    {
        $assetService->bulkUpdateMarketData();

        return 0;
    }
}
