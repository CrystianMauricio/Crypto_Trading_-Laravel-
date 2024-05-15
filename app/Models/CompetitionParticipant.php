<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   CompetitionParticipant.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models;

use App\Models\Formatters\Formatter;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompetitionParticipant extends Pivot
{
    use Formatter;

    
    protected $hidden = [
        'id', 'competition_id', 'user_id', 'created_at', 'updated_at'
    ];

    
    protected $appends = ['pnl'];

    
    protected $casts = [
        'start_balance'     => 'float',
        'current_balance'   => 'float',
    ];

    protected $formats = [
        'start_balance'     => 'decimal',
        'current_balance'   => 'decimal',
        'pnl'               => 'decimal',
    ];

    public function getPnlAttribute() {
        return $this->current_balance - $this->start_balance;
    }
}