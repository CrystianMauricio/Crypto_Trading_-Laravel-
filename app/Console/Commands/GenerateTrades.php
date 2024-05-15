<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   GenerateTrades.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Console\Commands;

use App\Models\Competition;
use App\Models\User;
use App\Services\CompetitionBotService;
use Illuminate\Console\Command;

class GenerateTrades extends Command
{
    
    protected $signature = 'generate:trades';

    
    protected $description = 'Generate trades (users with role BOT will trade automatically).';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle(CompetitionBotService $competitionBotService)
    {
        $competitionBotService->run();

        return 0;
    }
}
