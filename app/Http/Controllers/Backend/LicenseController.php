<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   LicenseController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Backend;

use App\Services\DotEnvService;
use App\Services\LicenseService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LicenseController extends Controller
{
    public function index() {
        return view('pages.backend.license');
    }

    public function register(Request $request, LicenseService $ls, DotEnvService $dotEnvService) {
        $result = $ls->register($request->code, $request->email);

        if ($result->success) {
            $dotEnvService->save([FP_CODE => $request->code, FP_EMAIL => $request->email, FP_HASH => $result->message]);
            return redirect()->route('backend.license.index')->with('success', __('Your license is successfully registered!'));
        } else {
            $dotEnvService->save(collect([FP_CODE, FP_EMAIL, FP_HASH])->mapWithKeys(function ($v) { return [$v => NULL]; })->toArray());
            return back()->withInput()->withErrors($result->message);
        }
    }
}
