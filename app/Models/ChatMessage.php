<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   ChatMessage.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $hidden = ['created_at', 'updated_at'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}