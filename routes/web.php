<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   web.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Backend\AddonController;
use App\Http\Controllers\Backend\AssetController as BackendAssetController;
use App\Http\Controllers\Backend\CompetitionController as BackendCompetitionController;
use App\Http\Controllers\Backend\DashboardController as BackendDashboardController;
use App\Http\Controllers\Backend\LicenseController;
use App\Http\Controllers\Backend\MaintenanceController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TradeController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\Frontend\AssetController;
use App\Http\Controllers\Frontend\ChatMessageController;
use App\Http\Controllers\Frontend\CompetitionController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\LocaleController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\RankingController;
use App\Http\Controllers\Frontend\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;



if (config('settings.image_url_generation') == 'route') {
    Route::get('storage/images/{type}/{image}', function ($type, $image) {
        try {
            $image = Storage::get($type . '/' . $image);
        } catch (Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            abort(404);
        }

        return Image::make($image)->response();
    })->name('assets.image');
}


Route::group(['middleware' => 'cookie-consent'], function () {
    Auth::routes(['verify' => config('settings.users.email_verification')]);
});


Route::prefix('login')
    ->name('login.')
    ->middleware(['guest','social'])
    ->group(function () {
        Route::get('{provider}', [SocialLoginController::class, 'redirect']);
        Route::get('{provider}/callback', [SocialLoginController::class, 'сallback']);
    });



Route::name('frontend.')
    ->middleware('cookie-consent')
    ->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('index');
        Route::get('page/{slug}', [PageController::class, 'display']);
        Route::post('cookie/accept', [PageController::class, 'acceptCookies']);
    });


Route::name('frontend.')
    ->middleware(['auth','active','email_verified','cookie-consent'])
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class,  ['only' => ['show','edit','index','update']]);
        Route::resource('competitions', CompetitionController::class, ['only' => ['index','show']]);
        Route::post('competitions/{competition}/join', [CompetitionController::class, 'join'])->name('competitions.join');
        Route::post('competitions/{competition}/assets/{asset}/trade', [CompetitionController::class, 'openTrade'])->name('competitions.trade.open');
        Route::get('competitions/{competition}/assets/search/{query}', [CompetitionController::class, 'searchAsset'])->name('competitions.assets.search');
        Route::post('competitions/{competition}/trades/{trade}/close', [CompetitionController::class, 'closeTrade'])->name('competitions.trade.close');
        Route::get('competitions/{competition}/history', [CompetitionController::class, 'history'])->name('competitions.history');
        Route::get('competitions/{competition}/leaderboard', [CompetitionController::class, 'leaderboard'])->name('competitions.leaderboard');
        Route::get('competitions/{competition}/trades', [CompetitionController::class, 'trades'])->name('competitions.trades');
        Route::get('competitions/{competition}/participants', [CompetitionController::class, 'participants'])->name('competitions.participants');
        Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
        Route::get('assets/search/{query}', [AssetController::class, 'search'])->name('assets.search');
        Route::post('assets/info', [AssetController::class, 'info'])->name('assets.info');
        Route::post('assets/{asset}/remember', [AssetController::class, 'remember'])->name('assets.remember');
        Route::get('rankings', [RankingController::class, 'index'])->name('rankings');
        
        Route::get('chat', [ChatMessageController::class, 'index'])->name('chat.index');
        Route::get('chat/messages/get', [ChatMessageController::class, 'getMessages'])->name('chat.messages.get');
        Route::post('chat/messages/send', [ChatMessageController::class, 'sendMessage'])->name('chat.messages.send');
        
        Route::post('locale/{locale}/remember', [LocaleController::class, 'remember'])->name('locale.remember');
        Route::get('help', [PageController::class, 'help'])->name('help');
    });



Route::get('js/variables.js', function () {
    $variables = Cache::rememberForever('variables.js', function () {
        $strings = require resource_path('lang/' . config('app.locale') . '/app.php');
        $config = [
            'color'                             => config('settings.color'),
            'number_decimal_point'              => config('settings.number_decimal_point'),
            'number_thousands_separator'        => config('settings.number_thousands_separator'),
            'assets_quotes_refresh_freq'        => config('settings.assets_quotes_refresh_freq'),
        ];

        $broadcasting = [
            'connections' => [
                'pusher' => [
                    'key' => config('broadcasting.connections.pusher.key'),
                    'options' => [
                        'cluster' => config('broadcasting.connections.pusher.options.cluster')
                    ]
                ]
            ]
        ];

        return 'var cfg = ' . json_encode(['settings' => $config, 'broadcasting' => $broadcasting]) . '; var i18n = ' . json_encode(['app' => $strings]) . ';';
    });

    return response($variables)->header('Content-Type', 'text/javascript');
})->name('assets.i18n');


Route::prefix('admin')
    ->name('backend.')
    ->middleware(['auth','active','email_verified','role:' . App\Models\User::ROLE_ADMIN])
    ->group(function () {
        
        Route::get('/', [BackendDashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('assets', BackendAssetController::class, ['except' => ['show']]);
        Route::get('assets/{asset}/delete', [BackendAssetController::class, 'delete'])->name('assets.delete');
        
        Route::resource('users', BackendUserController::class,  ['except' => ['create','store','show']]);
        Route::get('users/{user}/delete', [BackendUserController::class, 'delete'])->name('users.delete');
        Route::post('users/generate', [BackendUserController::class, 'generate'])->name('users.generate');
        
        Route::resource('competitions', BackendCompetitionController::class,  ['except' => ['show']]);
        Route::get('competitions/{competition}/delete', [BackendCompetitionController::class, 'delete'])->name('competitions.delete');
        Route::get('competitions/{competition}/clone', [BackendCompetitionController::class, 'duplicate'])->name('competitions.clone');
        Route::get('competitions/{competition}/bots/add', [BackendCompetitionController::class, 'addBotsForm'])->name('competitions.bots.add');
        Route::post('competitions/{competition}/bots/add', [BackendCompetitionController::class, 'addBots'])->name('competitions.bots.add');
        Route::get('competitions/{competition}/bots/remove', [BackendCompetitionController::class, 'removeBotsForm'])->name('competitions.bots.remove');
        Route::post('competitions/{competition}/bots/remove', [BackendCompetitionController::class, 'removeBots'])->name('competitions.bots.remove');
        
        Route::resource('trades', TradeController::class,  ['only' => ['index','edit']]);
        
        Route::get('add-ons', [AddonController::class, 'index'])->name('addons.index');
        
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        
        Route::get('maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
        Route::post('maintenance/cache/clear', [MaintenanceController::class, 'cache'])->name('maintenance.cache');
        Route::post('maintenance/migrate', [MaintenanceController::class, 'migrate'])->name('maintenance.migrate');
        Route::post('maintenance/cron', [MaintenanceController::class, 'cron'])->name('maintenance.cron');
        Route::post('maintenance/cron/assets-market-data', [MaintenanceController::class, 'cronAssetsMarketData'])->name('maintenance.cron_assets_market_data');
        Route::post('maintenance/cron/currencies-market-data', [MaintenanceController::class, 'cronCurrenciesMarketData'])->name('maintenance.cron_currencies_market_data');
        Route::get('license', [LicenseController::class, 'index'])->name('license.index');
        Route::post('license', [LicenseController::class, 'register'])->name('license.register');
    });
