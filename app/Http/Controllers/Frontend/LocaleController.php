<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   LocaleController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Frontend;

use App\Services\LocaleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocaleController extends Controller
{
    public function remember($locale, Request $request, LocaleService $localeService) {
        if (in_array($locale, $localeService->codes()))
            $request->session()->put('locale', $locale);

        return ['success' => TRUE];
    }
}
