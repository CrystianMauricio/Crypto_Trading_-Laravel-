<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   ConfirmPasswordController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    

    use ConfirmsPasswords;

    
    protected $redirectTo = RouteServiceProvider::HOME;

    
    public function __construct()
    {
        $this->middleware('auth');
    }
}
