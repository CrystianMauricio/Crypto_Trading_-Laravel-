<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   Formatter.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Formatters;
use Illuminate\Support\Facades\Log;


trait Formatter
{
    public function getAttribute($key) {
        
        $format = substr($key, 0, 1) == '_';
        if ($format)
            $key = substr($key, 1);

        
        $value = parent::getAttribute($key);

        
        if ($format && isset($this->formats) && array_key_exists($key, $this->formats) && method_exists($this, $this->formats[$key]))
            $value = $this->{$this->formats[$key]}($value);

        return $value;
    }

    
    private function integer($value) {
        return number_format($value, 0, $this->decimalPoint(), $this->thousandsSeparator());
    }

    
    private function decimal($value) {
        return number_format($value, $this->decimals(), $this->decimalPoint(), $this->thousandsSeparator());
    }

    
    private function variableDecimal($value) {
        $absValue = abs($value);
        if ($absValue >= 10) {
            $decimals = 2;
        } elseif (0.1 <= $absValue && $absValue < 10) {
            $decimals = 4;
        } elseif ($absValue < 0.1) {
            $decimals = 8;
        }

        return number_format($value, $decimals, $this->decimalPoint(), $this->thousandsSeparator());
    }

    private function percentage($value) {
        return $this->decimal($value) . '%';
    }

    private function decimals() {
        return config('settings.number_decimals');
    }

    private function decimalPoint() {
        return chr(config('settings.number_decimal_point'));
    }

    private function thousandsSeparator() {
        return chr(config('settings.number_thousands_separator'));
    }
}