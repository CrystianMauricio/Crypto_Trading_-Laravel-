<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AssetCanBeTraded.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Rules;

use App\Models\Asset;
use App\Models\Competition;
use Illuminate\Contracts\Validation\Rule;

class AssetCanBeTraded implements Rule
{
    private $competition;
    private $asset;

    
    public function __construct(Competition $competition, Asset $asset)
    {
        $this->competition = $competition;
        $this->asset = $asset;
    }

    
    public function passes($attribute, $value)
    {
        
        $allowedAssets = $this->competition->assetsIds();

        return $this->asset->status == Asset::STATUS_ACTIVE && $this->asset->price > 0 &&
            
            ($allowedAssets->count() == 0 || in_array($this->asset->id, $allowedAssets->toArray()));
    }

    
    public function message()
    {
        return __('app.asset_not_tradeable');
    }
}
