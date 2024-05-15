<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   GenerateUsers.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Console\Commands;

use App\Services\UserService;
use Illuminate\Console\Command;

class GenerateUsers extends Command
{
    
    protected $signature = 'generate:users {count=10}';

    
    protected $description = 'Generate users (bots).';

    
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
        for ($i=0; $i < $this->argument('count'); $i++) {
            UserService::create();
        }

        return 0;
    }
}
