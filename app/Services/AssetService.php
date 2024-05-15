<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AssetService.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services;

use App\Models\Asset;
use App\Models\Currency;
use App\Services\API\CoinCapApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AssetService extends Service
{
    private $api;

    public function __construct()
    {
        $this->api = new CoinCapApi();
    }

    
    public function asset(Asset $asset) {
        $cacheTime = intval(config('settings.assets_quotes_rest_api_poll_freq')); 
        return Cache::remember('asset-' . $asset->id, $cacheTime, function () use ($asset) {
            return $this->updateMarketData($asset);
        });
    }

    
    public function updateMarketData(Asset $asset) {
        if ($asset->external_id) {
            $data = $this->api->quote($asset->external_id);

            if (isset($data->data)) {
                $quote = $data->data;
                Log::info(json_encode($quote));
                $baseCurrencyRate = $this->baseCurrencyRate();
                $asset->price = $quote->priceUsd && $baseCurrencyRate ? $quote->priceUsd / $baseCurrencyRate : 0;
                $asset->volume = $quote->volumeUsd24Hr && $baseCurrencyRate ? $quote->volumeUsd24Hr / $baseCurrencyRate : 0;
                $asset->supply = $quote->supply ?: 0;
                $asset->market_cap = $quote->marketCapUsd && $baseCurrencyRate ? $quote->marketCapUsd / $baseCurrencyRate : 0;

                try {
                    $asset->save();
                } catch (\Exception $e) {
                    Log::error(sprintf('Error updating data for %s: %s %s', $asset->external_id, $e->getMessage(), json_encode($asset->toArray())));
                }
            }
        }

        return $asset;
    }

    public function bulkUpdateMarketData() {
        
        $quotes = collect((array) $this->api->quotes()->data ?? [])->keyBy('id');

        $baseCurrencyRate = $this->baseCurrencyRate();

        
        foreach (Asset::cursor() as $asset) {
            if ($quote = $quotes->get($asset->external_id)) {
                $asset->symbol      = $quote->symbol;
                $asset->name        = $quote->name;
                $asset->price       = $quote->priceUsd ? $quote->priceUsd / $baseCurrencyRate : 0;
                $asset->change_pct  = $quote->changePercent24Hr ? round($quote->changePercent24Hr, 2) : 0;
                $asset->change_abs  = 100 + $asset->change_pct != 0 ? $asset->price * $asset->change_pct / (100 + $asset->change_pct) : -$asset->price;
                $asset->volume      = $quote->volumeUsd24Hr ? $quote->volumeUsd24Hr / $baseCurrencyRate : 0;
                $asset->supply      = $quote->supply ?: 0;
                $asset->market_cap  = $quote->marketCapUsd ? $quote->marketCapUsd / $baseCurrencyRate : 0;

                try {
                    $asset->save();
                } catch (\Exception $e) {
                    Log::error(sprintf('Error updating data for %s: %s %s', $asset->external_id, $e->getMessage(), json_encode($asset->toArray())));
                }
            } else {
                Log::warning(sprintf('No quote found for %s', $asset->external_id));
            }
        }
    }

    
    private function baseCurrencyRate() {
        
        
        if (config('settings.currency') != 'USD') {
            
            $baseCurrencyRate = Currency::find(1)->rate ?: 1;
        } else {
            $baseCurrencyRate = 1;
        }

        return $baseCurrencyRate;
    }
}
