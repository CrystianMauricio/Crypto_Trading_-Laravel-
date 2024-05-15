<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   DatabaseSeeder.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        

        
        
        
        

        $this->call(AssetSeeder::class);
        $this->call(CurrencySeeder::class);

        
        foreach (glob(__DIR__ . '/../../packages/**/database/seeders/*.php') as $seederFile) {
            $seederClass = str_replace('.php', '', basename($seederFile));
            $this->call($seederClass);
        }
    }
}
