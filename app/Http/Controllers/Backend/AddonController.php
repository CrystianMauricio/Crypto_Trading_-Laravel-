<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AddonController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Backend;

use App\Helpers\PackageManager;
use App\Http\Controllers\Controller;

class AddonController extends Controller
{
    public function index(PackageManager $packageManager) {
        return view('pages.backend.addons', [
            'packages' => $packageManager->getAll()
        ]);
    }
}
