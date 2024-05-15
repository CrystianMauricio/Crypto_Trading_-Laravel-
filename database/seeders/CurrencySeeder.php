<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CurrencySeeder.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    
    public function run(): void
    {
        
        if (DB::table('currencies')->count() != 0) {
            return;
        }

        $now = Carbon::now();
        $currencies = (array) json_decode(file_get_contents(base_path() . '/database/seeders/data/currencies.json'));

        foreach ($currencies as $currency) {
            Currency::firstOrCreate(
                [
                    'code' => $currency->code
                ],
                [
                    'name' => $currency->name,
                    'symbol_native' => $currency->symbol_native,
                    'rate' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
