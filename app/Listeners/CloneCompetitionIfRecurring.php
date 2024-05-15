<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CloneCompetitionIfRecurring.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Listeners;

use App\Events\AfterCompetitionClosed;
use App\Models\Competition;
use App\Services\CompetitionService;

class CloneCompetitionIfRecurring
{
    
    public function __construct()
    {
        
    }

    
    public function handle(AfterCompetitionClosed $event) {
        $competition = $event->competition();

        
        if ($competition->recurring) {
            $competitionService = new CompetitionService($competition);
            $competitionService->clone();
        }
    }
}