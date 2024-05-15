<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   LocaleService.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Services;

class LocaleService
{
    
    private $flags = [
        'en' => 'us',
        'da' => 'dk',
        'el' => 'gr',
        'cs' => 'cz',
        'sv' => 'se',
        'sl' => 'si',
        'et' => 'ee'
    ];

    private $locales;
    private $locale; 

    public function __construct()
    {
        $this->locale = app()->getLocale();

        $this->locales = new \stdClass();
        
        foreach (glob(resource_path('lang/*'), GLOB_ONLYDIR) as $folder) {
            $languageCode = substr($folder, strrpos($folder, '/') + 1);
            $this->locales->$languageCode = new \stdClass();
            $this->locales->$languageCode->flag = array_key_exists($languageCode, $this->flags) ? $this->flags[$languageCode] : $languageCode;
            $this->locales->$languageCode->name = __('language.' . $languageCode);
        }
    }


    
    public function locale() {
        return $this->locales->{$this->locale};
    }

    
    public function locales()
    {
        return $this->locales;
    }

    
    public function codes() {
        return array_keys(get_object_vars($this->locales));
    }

    
    public function code() {
        return $this->locale;
    }

}