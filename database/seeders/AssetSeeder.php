<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AssetSeeder.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    
    public function run(): void
    {
        
        $data = collect(json_decode(file_get_contents(base_path() . '/database/seeders/data/coins.json')));

        
        foreach ($data as $item) {
            Asset::updateOrCreate(
                [
                    'external_id' => $item->external_id,
                ],
                [
                    'symbol' => $item->symbol,
                    'name' => $item->name,
                    'logo' => isset($item->logo) ? $item->logo : NULL,
                    'status' => Asset::STATUS_ACTIVE
                ]
            );
        }

        
        Asset::whereNotIn('external_id', $data->pluck('id'))->update(['status' => Asset::STATUS_BLOCKED]);
    }
}
