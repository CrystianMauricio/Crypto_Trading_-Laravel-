<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   cors.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

return [

    

    
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    
    'allowed_methods' => ['*'],

    
    'allowed_origins' => ['*'],

    
    'allowed_origins_patterns' => [],

    
    'allowed_headers' => ['*'],

    
    'exposed_headers' => false,

    
    'max_age' => false,

    
    'supports_credentials' => false,
];
