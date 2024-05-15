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

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\UpdateUser;
use App\Models\Sort\Backend\UserSort;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    
    public function index(Request $request, User $user)
    {
        $sort = new UserSort($request);

        $users = User::orderBy($sort->getSortColumn(), $sort->getOrder())
            ->with('profiles')
            ->paginate($this->rowsPerPage);

        return view('pages.backend.users.index', [
            'users'     => $users,
            'sort'      => $sort->getSort(),
            'order'     => $sort->getOrder(),
        ]);
    }


    
    public function show(User $user)
    {

    }

    
    public function edit(User $user)
    {
        return view('pages.backend.users.edit', ['user' => $user]);
    }

    
    public function update(UpdateUser $request, User $user)
    {
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;

        
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
        
        } else if ($user->avatar) {
            Storage::delete('avatars/' . $user->avatar);
            $user->avatar = NULL;
        }

        
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()
            ->route('backend.users.index')
            ->with('success', __('users.saved', ['name' => $user->name]));
    }

    
    public function delete(Request $request, User $user) {
        
        if ($request->user()->id == $user->id) {
            return redirect()
                ->back()
                ->withErrors(['user' => __('users.error_delete_self')]);
        }

        $request->session()->flash('warning', __('users.delete_warning'));
        return view('pages.backend.users.delete', ['user' => $user]);
    }

    
    public function destroy(Request$request, User $user)
    {
        
        if ($request->user()->id == $user->id) {
            return redirect()
                ->back()
                ->withErrors(['user' => __('users.error_delete_self')]);
        }

        $userName = $user->name;

        
        if ($user->avatar)
            Storage::delete('avatars/' . $user->avatar);

        
        $user->delete();

        return redirect()
            ->route('backend.users.index')
            ->with('success', __('users.deleted', ['name' => $userName]));
    }

    
    public function generate(Request $request)
    {
        try {
            Artisan::call('generate:users', [
                'count' => $request->count
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('backend.users.index')
            ->with('success', __('users.bots_generated', ['n' => $request->count]));
    }
}