<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   User.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models;

use App\Models\Formatters\Formatter;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Fields\Enum;
use App\Models\Fields\EnumUserRole;
use App\Models\Fields\EnumUserStatus;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable implements EnumUserRole, EnumUserStatus, MustVerifyEmail
{
    use Notifiable {
        notify as protected _notify;
    }

    use Enum;
    use Formatter;

    
    protected $fillable = [
        'name', 'email', 'role', 'status', 'password', 'last_login_time', 'last_login_ip', 'email_verified_at'
    ];

    
    protected $hidden = [
        'email','password','remember_token','role','status','last_login_time','last_login_ip','created_at','updated_at'
    ];

    protected $casts = [
        'last_login_time' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    
    protected $appends = ['avatar_url'];

    protected $formats = [
        'trades_count'      => 'integer',
        'max_loss'          => 'decimal',
        'max_profit'        => 'decimal',
        'total_volume'      => 'decimal',
    ];

    
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return config('settings.image_url_generation') == 'storage'
                ? asset('storage/avatars/' . $this->avatar)
                : route('assets.image', ['avatars', $this->avatar]);
        } else {
            return asset('images/avatar.jpg');
        }
    }

    
    public function getRankAttribute() {
        
        

        $userRanks = User::selectRaw('users.id, SUM(points) AS points')
            ->where('status', User::STATUS_ACTIVE)
            ->leftJoin('user_points', 'user_points.user_id', '=', 'users.id')
            ->groupBy('users.id')
            ->orderBy('points', 'desc')
            ->orderBy('id', 'asc')
            ->get()
            ->mapWithKeys(function ($row, $key) {
                return [$row['id'] => $key+1];
            })
            ->toArray();

        return $userRanks[$this->id];
    }

    public function points() {
        return $this->hasMany(UserPoint::class);
    }

    public function trades() {
        return $this->hasMany(Trade::class);
    }

    public function profiles(){
        return $this->hasMany(SocialProfile::class);
    }

    public function openTrades() {
        return $this->trades()->where('trades.status', Trade::STATUS_OPEN);
    }

    public function closedTrades() {
        return $this->trades()->where('trades.status', Trade::STATUS_CLOSED);
    }

    public function lastTrades($limit) {
        return $this->trades()->with('asset', 'currency')->orderBy('trades.id', 'desc')->limit($limit);
    }

    
    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    
    public static function getRoles() {
        return self::getEnumValues('UserRole');
    }

    
    public static function getStatuses() {
        return self::getEnumValues('UserStatus');
    }

    
    public function hasRole($role) {
        return isset($this->role) && $this->role == $role;
    }

    
    public function admin() {
        return $this->hasRole(User::ROLE_ADMIN);
    }

    
    public function bot() {
        return $this->hasRole(User::ROLE_BOT);
    }

    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    
    public function notify($instance) {
        try {
            
            $this->_notify($instance);
        } catch (\Swift_TransportException $e) {
            Log::error('Swift_TransportException: ' . $e->getMessage());
            
            if (!config('app.debug')) {
                
                if (!App::runningInConsole()) {
                    request()->session()->forget('status');
                    back()
                        ->withInput(request()->only('email'))
                        ->withErrors(['server' => __('email.error')]);
                }
            } else {
                throw $e;
            }
        }
    }
}
