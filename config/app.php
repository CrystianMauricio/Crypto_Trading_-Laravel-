<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   app.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'version' => '2.1.0',

    

    'name' => env('APP_NAME', 'Crypto Trading Competitions'),

    

    'env' => env('APP_ENV', 'production'),

    

    'debug' => (bool) env('APP_DEBUG', false),

    

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    

    'timezone' => env('TIMEZONE', 'UTC'),

    

    'locale' => env('LOCALE', 'en'),

    

    'fallback_locale' => 'en',

    

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    'hash' => '4989ac78d02ee23e0c4359c7ac24a28e',

    

    'log' => env('APP_LOG', 'single'),

    
    'log_level' => env('LOG_LEVEL', 'emergency'),

    'api' => [
        'products' => [
            'base_uri' => env('API_PRODUCTS_BASE_URI', 'https://financialplugins.com/api/')
        ],
    ],

    

    'maintenance' => [
        'driver' => 'file',
        
    ],

    

    'providers' => ServiceProvider::defaultProviders()->merge([
        
        Intervention\Image\ImageServiceProvider::class,

        
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\ConfigServiceProvider::class,
    ])->toArray(),

    

    'aliases' => Facade::defaultAliases()->merge([
        
    ])->toArray(),

];
