<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   Utils.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Helpers;

class Utils
{
    
    public static function getPathToPhp(): string
    {
        return PHP_BINDIR . DIRECTORY_SEPARATOR . 'php';
    }

    
    public static function getCronJobCommand(): string
    {
        return '* * * * * ' . self::getPathToPhp() . ' -d register_argc_argv=On ' . base_path() . DIRECTORY_SEPARATOR . 'artisan schedule:run';
    }
}
