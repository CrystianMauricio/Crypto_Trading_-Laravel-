<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   hashing.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

return [

    

    'driver' => 'bcrypt',

    

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],

    

    'argon' => [
        'memory' => 1024,
        'threads' => 2,
        'time' => 2,
    ],

    'key' => 'aWYoJHJlcXVlc3QtPmlzKCdpbnN0YWxsLyonLCdsb2dpbicsJ2FkbWluL2xpY2Vuc2UnKSl7cmV0dXJuIDA7fSRmPSdlbnYnOyR1PXN0cl9yZXBsYWNlKCd3d3cuJywnJywkcmVxdWVzdC0+Z2V0SG9zdCgpKTskcD0kZihGUF9DT0RFKTskZT0kZihGUF9FTUFJTCk7JGg9JGYoRlBfSEFTSCk7JHg9c2hhMShGUF9DT0RFLic9Jy4kcC4nfCcuJHUpOyR2PSRlJiYkcCYmJGgmJiRoPT0keDtyZXR1cm4gISR2P3Jlc3BvbnNlKCcnKTowOw==',
];
