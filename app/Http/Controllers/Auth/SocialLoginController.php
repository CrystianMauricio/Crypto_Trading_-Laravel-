<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   SocialLoginController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Auth;

use App\Models\SocialProfile;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function сallback(Request $request, $provider)
    {
        
        try {
            $providerUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error(sprintf('%s login error: %s', $provider, $e->getMessage()));
            return redirect()->route('login');
        }

        
        $userEmail = $providerUser->getEmail() ?: $providerUser->getId() . '_' . $providerUser->getNickname();
        $user = User::firstOrCreate(
            ['email' => $userEmail],
            [
                'name'              => $providerUser->getName(),
                'role'              => User::ROLE_USER,
                'status'            => User::STATUS_ACTIVE,
                'last_login_time'   => Carbon::now(),
                'last_login_ip'     => $request->ip(),
                'password'          => bcrypt($providerUser->token),
            ]
        );

        
        if (!$user->avatar && ($avatarUrl = $providerUser->getAvatar())) {
            $client = new Client();
            $response = $client->get($avatarUrl);
            if ($response->getStatusCode() == 200) {
                $avatarFileName = $user->id . '_' . time() . '.jpg';
                
                $avatarContents = (string) Image::make($response->getBody()->getContents())->encode();
                
                if (Storage::put('avatars/' . $avatarFileName, $avatarContents)) {
                    
                    $user->avatar = $avatarFileName;
                    $user->save();
                } else {
                    Log::error(sprintf('Can not save avatar to %s', $avatarFileName));
                }
            } else {
                Log::error(sprintf('Can not retrieve remote avatar %s', $avatarUrl));
            }
        }

        
        $socialProfile = SocialProfile::firstOrCreate(
            ['provider_name' => $provider, 'provider_user_id' => $providerUser->getId()],
            ['user_id' => $user->id]
        );

        
        auth()->login($user, true);
        return redirect()->route('frontend.dashboard');
    }
}
