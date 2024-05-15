<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CloseCompetitions.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Console\Commands;

use App\Services\CompetitionExpiryService;
use Illuminate\Console\Command;

class CloseCompetitions extends Command
{
    
    protected $signature = 'competition:close';

    
    protected $description = 'Check if any competitions are expired (finished) and close them accordingly.';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle(CompetitionExpiryService $competitionExpiryService)
    {
        $competitionExpiryService->run();

        return 0;
    }
}
