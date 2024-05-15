<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   settings.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

return [
    
    'background' => env('BACKGROUND', 'white'),
    'color' => env('COLOR', 'teal'),

    
    'currency' => env('CURRENCY', 'USD'),

    
    'image_url_generation' => env('IMAGE_URL_GENERATION', 'storage'),

    'user_avatar_height' => env('USER_AVATAR_HEIGHT', 300),

    'asset_logo_thumb_height' => env('ASSET_LOGO_THUMB_HEIGHT', 64),

    
    'users' => [
        
        'email_verification' => env('USERS_EMAIL_VERIFICATION', FALSE),
    ],

    
    'recaptcha' => [
        'public_key'    => env('RECAPTCHA_PUBLIC_KEY'),
        'secret_key'    => env('RECAPTCHA_SECRET_KEY'),
    ],

    
    'points_type_trade_loss' => env('POINTS_TYPE_TRADE_LOSS', 2),
    'points_type_trade_profit' => env('POINTS_TYPE_TRADE_PROFIT', 5),
    'points_type_competition_join' => env('POINTS_TYPE_COMPETITION_JOIN', 10),
    'points_type_competition_place1' => env('POINTS_TYPE_COMPETITION_PLACE1', 50),
    'points_type_competition_place2' => env('POINTS_TYPE_COMPETITION_PLACE2', 40),
    'points_type_competition_place3' => env('POINTS_TYPE_COMPETITION_PLACE3', 30),

    'number_decimals' => env('NUMBER_DECIMALS', 2),
    'number_decimal_point' => env('NUMBER_DECIMAL_POINT', 46), 
    'number_thousands_separator' => env('NUMBER_THOUSANDS_SEPARATOR', 44), 

    
    'bots' => [
        'top_assets_limit' => env('BOTS_TOP_ASSETS_LIMIT', 100),
        'min_trades_to_open' => env('BOTS_MIN_TRADES_TO_OPEN', 1),
        'max_trades_to_open' => env('BOTS_MAX_TRADES_TO_OPEN', 3),
        'min_trades_to_close' => env('BOTS_MIN_TRADES_TO_CLOSE', 1),
        'max_trades_to_close' => env('BOTS_MAX_TRADES_TO_CLOSE', 3),
        'min_trade_life_time' => env('BOTS_MIN_TRADE_LIFE_TIME', 21600), 
    ],

    
    'gtm_container_id' => env('GTM_CONTAINER_ID'),


    
    'adsense_client_id' => env('ADSENSE_CLIENT_ID'),
    'adsense_top_slot_id' => env('ADSENSE_TOP_SLOT_ID'),
    'adsense_bottom_slot_id' => env('ADSENSE_BOTTOM_SLOT_ID'),

    
    'assets_quotes_refresh_freq' => env('ASSETS_QUOTES_REFRESH_FREQ', 5), 
    'assets_quotes_rest_api_poll_freq' => env('ASSETS_QUOTES_REST_API_POLL_FREQ', 10), 

    
    'openexchangerates_api_key' => env('OPENEXCHANGERATES_API_KEY'),

    
    'coincap_api_key' => env('COINCAP_API_KEY'),
];
