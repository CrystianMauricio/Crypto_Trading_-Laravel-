<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   UserController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\UpdateUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('self')->only(['edit','update']);
    }

    public function index(User $user){
        
        $trades = $user->closedTrades()->get();
        $tradesCount = $trades->count();

        $profitableTradesCount = $trades->filter(function ($trade) {
                return $trade->pnl > 0;
            })
            ->count();

        $unprofitableTradesCount = $trades->filter(function ($trade) {
                return $trade->pnl <= 0;
            })
            ->count();

        $recentTrades = $user->lastTrades(10)->get();

        return view('pages.frontend.users.changepassword', [
            'user'                          => $user
        ]);
    }
    public function show(User $user)
    {
        $trades = $user->closedTrades()->get();
        $tradesCount = $trades->count();

        $profitableTradesCount = $trades->filter(function ($trade) {
                return $trade->pnl > 0;
            })
            ->count();

        $unprofitableTradesCount = $trades->filter(function ($trade) {
                return $trade->pnl <= 0;
            })
            ->count();

        $recentTrades = $user->lastTrades(10)->get();

        return view('pages.frontend.users.show', [
            'user'                          => $user,
            'trades_count'                  => $tradesCount,
            'profitable_trades_count'       => $profitableTradesCount,
            'unprofitable_trades_count'     => $unprofitableTradesCount,
            'recent_trades'                 => $recentTrades,
        ]);
    }

    
    public function edit(User $user, Request $request)
    {
        return view('pages.frontend.users.edit', ['user' => $user]);
    }

    
    public function update(UpdateUser $request, User $user)
    {
        
        $user->name = $request->name;
        $user->email = $request->email;

        
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarFileName = $user->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            
            $avatarContents = (string) Image::make($avatar)
                ->resize(null, config('settings.user_avatar_height'), function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode();

            
            if (Storage::put('avatars/' . $avatarFileName, $avatarContents)) {
                
                if ($user->avatar)
                    Storage::delete('avatars/' . $user->avatar);
                
                $user->avatar = $avatarFileName;
            }
        
        } else if ($request->deleted === 'true' && $user->avatar) {
            Storage::delete('avatars/' . $user->avatar);
            $user->avatar = NULL;
        }

        $user->save();

        return redirect()
            ->route('frontend.users.show', $user)
            ->with('success', __('users.saved', ['name' => $user->name]));
    }
}
