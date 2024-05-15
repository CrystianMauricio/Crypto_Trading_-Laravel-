<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   Trade.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models;

use App\Models\Currency;
use App\Models\Fields\Enum;
use App\Models\Fields\EnumTradeDirection;
use App\Models\Fields\EnumTradeStatus;
use App\Models\Formatters\Formatter;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model implements EnumTradeDirection, EnumTradeStatus
{
    use Enum, Formatter;

    
    public $unrealizedPnl;

    
    protected $hidden = ['competition_id','user_id','asset_id','status','updated_at'];

    
    protected $casts = [
        'price_open'    => 'float',
        'price_close'   => 'float',
        'lot_size'      => 'integer',
        'volume'        => 'float',
        'quantity'      => 'integer',
        'margin'        => 'float',
        'pnl'           => 'float',
        'closed_at'     => 'datetime',
    ];

    protected $formats = [
        'lot_size'          => 'integer',
        'volume'            => 'decimal',
        'quantity'          => 'integer',
        'price_open'        => 'variableDecimal',
        'price_close'       => 'variableDecimal',
        'margin'            => 'decimal',
        'pnl'               => 'decimal',
    ];

    
    protected $appends = ['direction_sign', 'quantity'];

    public function competition() {
        return $this->belongsTo(Competition::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function asset() {
        return $this->belongsTo(Asset::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }

    public function getDirectionSignAttribute() {
        return $this->direction == self::DIRECTION_BUY ? 1 : -1;
    }

    public function getQuantityAttribute() {
        return $this->volume * $this->lot_size;
    }
}
