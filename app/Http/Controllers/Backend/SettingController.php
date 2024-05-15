<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   SettingController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Backend;

use App\Events\BeforeSettingsSaved;
use App\Models\Currency;
use App\Services\DotEnvService;
use App\Services\LocaleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index(Request $request) {
        $locale = new LocaleService();
        $locales = $locale->locales();
        $currencies = Currency::get();
        $backgrounds = ['white','black'];
        $colors = ['red','orange','yellow','olive','green','teal','blue','violet','purple','pink','brown','grey','black'];
        $logLevels = ['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'];
        $apiTypes = ['WS', 'REST'];
        $separators = [ord('.') => '.', ord(',') => ',', ord(' ') => __('settings.space'), ord(':') => ':', ord(';') => ';', ord('-') => '-'];

        if (config('settings.currency') != 'USD' && !config('settings.openexchangerates_api_key')) {
            $request->session()->flash('warning', __('app.openexchangerates_api_key_missing', ['url' => 'https://openexchangerates.org/signup/free']));
        }

        if (!config('settings.coincap_api_key')) {
            $request->session()->flash('warning', __('app.coincap_api_key_missing', ['url' => 'https://coincap.io/api-key']));
        }

        return view('pages.backend.settings', [
            'backgrounds'   => $backgrounds,
            'colors'        => $colors,
            'locales'       => $locales,
            'currencies'    => $currencies,
            'log_levels'    => $logLevels,
            'separators'    => $separators,
            'api_types'     => $apiTypes,
        ]);
    }

    public function update(Request $request, DotEnvService $dotEnvService) {
        event(new BeforeSettingsSaved($request));

        
        if (!$dotEnvService->save($request->except(['_token', 'nonenv']))) {
            return redirect()->back()->withErrors(__('There was an error while saving the settings.'));
        }

        
        Cache::forget('variables.js');

        return redirect()->back()->with('success', __('settings.saved'));
    }
}
