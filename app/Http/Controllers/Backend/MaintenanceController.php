<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   MaintenanceController.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Http\Controllers\Backend;

use App\Helpers\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class MaintenanceController extends Controller
{
    public function index() {
        return view('pages.backend.maintenance', [
            'system_info' => [
                __('OS') => php_uname(),
                __('Web server') => $_SERVER['SERVER_SOFTWARE'],
                __('PHP version') => PHP_VERSION,
                __('Path to PHP') => Utils::getPathToPhp(),
                __('Installation folder') => base_path(),
                __('Laravel version') => app()->version(),
            ],
        ]);
    }

    
    public function cache() {
        Cache::flush();
        Artisan::call('view:clear');
        return $this->success();
    }

    
    public function migrate() {
        
        Artisan::call('migrate', [
            '--force' => TRUE,
        ]);
        
        Artisan::call('db:seed', [
            '--force' => TRUE,
        ]);

        return $this->success();
    }

    
    public function cron() {
        set_time_limit(1800);
        Artisan::call('schedule:run');
        return $this->success();
    }

    public function cronAssetsMarketData() {
        set_time_limit(1800);
        Artisan::call('asset:update');
        return $this->success();
    }

    public function cronCurrenciesMarketData() {
        set_time_limit(1800);
        Artisan::call('currency:update');
        return $this->success();
    }

    private function success() {
        return redirect()->route('backend.maintenance.index')->with('success', __('maintenance.success'));
    }
}
