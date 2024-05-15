<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UserPoint.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models;

use App\Models\Fields\EnumUserPointType;
use App\Models\Formatters\Formatter;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model implements EnumUserPointType
{
    use Formatter;

    
    protected $casts = [
        'points' => 'integer',
    ];

    protected $formats = [
        'points' => 'integer',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
