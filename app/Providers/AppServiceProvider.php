<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AppServiceProvider.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Providers;

use Illuminate\Support\Arr;
use App\Helpers\PackageManager;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private $packageManager;

    
    public function boot(): void
    {
        
        View::share('settings', (object)config('settings'));
        
        View::share('inverted', config('settings.background')=='black' ? 'inverted' : '');
        
        DB::listen(function ($query) {
            Log::debug($query->sql, ['params' => $query->bindings, 'time' => $query->time]);
        });

        
        Blade::if('social', function ($provider = NULL) {
            $providers = $provider ? [$provider] : ['facebook','google','twitter','linkedin'];

            $check = function($p) {
                return config('services.'.$p.'.client_id')
                && config('services.'.$p.'.client_secret')
                && config('services.'.$p.'.redirect');
            };

            
            foreach ($providers as $p) {
                if ($check($p))
                    return TRUE;
            }

            return FALSE;
        });

        
        Blade::directive('packageview', function ($view) {
            $view = str_replace('\'', '', $view); 
            $expression = '';

            
            foreach ($this->packageManager->getInstalled() as $package) {
                if (view()->exists($package->id . '::' . $view)) {
                    $expression .= 'echo $__env->make("' . $package->id . '::' . $view . '", Arr::except(get_defined_vars(), array("__data", "__path")))->render();';
                }
            }

            return $expression ? '<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   AppServiceProvider.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/ ' . $expression . '?>' : '';
        });

        $this->loadRoutesFrom(base_path('routes/validation.php'));

        $path = base_path('routes/debug.php');
        if (File::exists($path)) {
            $this->loadRoutesFrom($path);
        }

        
        Paginator::defaultView('vendor.pagination.default');
    }

    
    public function register(): void
    {
        $packageManager = new PackageManager();
        $this->packageManager = $packageManager;

        
        if (count($packageManager->getInstalled())) {
            
            spl_autoload_register([$packageManager, 'autoload']);

            
            foreach ($packageManager->getInstalled() as $package) {
                foreach ($package->providers as $provider) {
                    $this->app->register($provider);
                }
            }
        }
    }
}
