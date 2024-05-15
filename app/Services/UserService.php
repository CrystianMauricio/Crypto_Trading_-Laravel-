<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UserService.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserService
{
    
    public static function create($name = NULL, $email = NULL, $password = NULL)
    {
        
        $faker = Faker::create();

        
        $user = new User();
        $user->name = $name ?: $faker->name;
        $user->email = $email ?: $faker->safeEmail;
        $user->role = User::ROLE_BOT;
        $user->status = User::STATUS_ACTIVE;
        $user->password = Hash::make(Str::random(8));
        $user->remember_token = Str::random(10);
        $user->last_login_ip = $faker->ipv4;
        $user->last_login_time = Carbon::now();
        $user->save();

        
        event(new Registered($user));

        return $user;
    }
}
