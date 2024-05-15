<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AssetPriceIsValid.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Rules;

use App\Models\Asset;
use Illuminate\Contracts\Validation\Rule;

class AssetPriceIsValid implements Rule
{
    private $asset;

    
    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    
    public function passes($attribute, $value)
    {
        return $this->asset->price > 0;
    }

    
    public function message()
    {
        return __('app.asset_not_tradeable');
    }
}
