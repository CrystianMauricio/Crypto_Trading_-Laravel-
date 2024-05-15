<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   Asset.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models;

use App\Models\Fields\Enum;
use App\Models\Fields\EnumAssetStatus;
use App\Models\Formatters\Formatter;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model implements EnumAssetStatus
{
    use Enum, Formatter;

    
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['type','status','created_at','updated_at'];

    
    protected $appends = ['logo_url', 'title'];

    
    protected $casts = [
        'price'             => 'float',
        'change_abs'        => 'float',
        'change_pct'        => 'float',
        'supply'            => 'float', 
        'volume'            => 'float', 
        'market_cap'        => 'float', 
    ];

    protected $formats = [
        'price'             => 'variableDecimal',
        'change_abs'        => 'variableDecimal',
        'change_pct'        => 'decimal',
        'supply'            => 'integer',
        'volume'            => 'integer',
        'market_cap'        => 'integer',
        'trades_count'      => 'integer',
    ];

    
    public function getLogoUrlAttribute()
    {
        return $this->logo
            ? (config('settings.image_url_generation') == 'storage'
                ? asset('storage/assets/' . $this->logo)
                : route('assets.image', ['assets', $this->logo]))
            : asset('images/asset.png');
    }

    
    public function getTitleAttribute()
    {
        return $this->symbol;
    }

    
    public static function getStatuses()
    {
        return self::getEnumValues('AssetStatus');
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    
    public function competitions()
    {
        return $this->belongsToMany(Competition::class, 'competition_assets');
    }
}
