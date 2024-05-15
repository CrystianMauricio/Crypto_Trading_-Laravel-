<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   Competition.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models;

use App\Models\Fields\Enum;
use App\Models\Fields\EnumCompetitionDuration;
use App\Models\Fields\EnumCompetitionStatus;
use App\Models\Formatters\Formatter;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model implements EnumCompetitionStatus, EnumCompetitionDuration
{
    use Enum, Formatter;

    protected $guarded = ['id'];

    
    protected $hidden = ['user_id', 'status', 'created_at', 'updated_at'];

    
    protected $casts = [
        'lot_size'          => 'integer',
        'leverage'          => 'integer',
        'start_balance'     => 'float',
        'volume_min'        => 'float',
        'volume_max'        => 'float',
        'min_margin_level'  => 'float',
        'fee'               => 'float',
        'start_time'        => 'datetime',
        'end_time'          => 'datetime',
    ];

    protected $formats = [
        'lot_size'          => 'integer',
        'leverage'          => 'integer',
        'start_balance'     => 'decimal',
        'volume_min'        => 'decimal',
        'volume_max'        => 'decimal',
        'min_margin_level'  => 'percentage',
        'fee'               => 'decimal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function participants()
    {
        return $this->belongsToMany(User::class, 'competition_participants')
            ->using(CompetitionParticipant::class)
            ->as('data')
            ->withPivot('id', 'start_balance', 'current_balance', 'place') 
            ->withTimestamps();
    }

    public function participant(User $user)
    {
        return $this->participants()->where('user_id', $user->id)->first();
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function openTrades()
    {
        return $this->trades()->where('status', Trade::STATUS_OPEN);
    }

    public function closedTrades()
    {
        return $this->trades()->where('status', Trade::STATUS_CLOSED);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'competition_assets');
    }

    
    public function assetsIds()
    {
        return $this->assets()->get()->pluck('id');
    }

    
    public function getPayoutsAttribute() {
        return $this->payout_structure ? unserialize($this->payout_structure) : [];
    }
}
