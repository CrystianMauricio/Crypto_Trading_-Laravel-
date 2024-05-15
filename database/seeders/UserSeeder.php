<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UserSeeder.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    
    public function run(): void
    {
        factory(User::class, 30)->create();
    }
}
