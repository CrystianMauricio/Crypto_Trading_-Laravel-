<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   SocialProfile.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialProfile extends Model
{
    
    protected $fillable = [
        'user_id', 'provider_name', 'provider_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
