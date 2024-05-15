<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CheckMarginLevel.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Console\Commands;

use App\Services\MarginCallService;
use Illuminate\Console\Command;

class CheckMarginLevel extends Command
{
    
    protected $signature = 'competition:check-margin';

    
    protected $description = 'Check margin level requirements for every participant in each open competition.';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle(MarginCallService $marginCallService)
    {
        $marginCallService->run();

        return 0;
    }
}
