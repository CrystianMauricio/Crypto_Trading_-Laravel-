<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   PackageManager.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Helpers;


class PackageManager
{
    private $packages = [];
    private $appDirectory;

    function __construct()
    {
        $this->appDirectory = __DIR__ . '/../../';

        
        foreach (glob($this->appDirectory . 'packages/*/config.json') as $configFile) {
            if ($package = json_decode(file_get_contents($configFile))) {
                $this->packages[$package->id] = $package;
                $this->packages[$package->id]->installed = $this->installed($package->id);
                if ($this->packages[$package->id]->installed) {
                    $this->packages[$package->id]->version = config($package->id . '.version');
                }
            }
        }

        return $this;
    }

    
    public function getAll()
    {
        return $this->packages;
    }


    
    public function getInstalled() {
        return array_filter($this->packages, function($package) {
            return $package->installed;
        });
    }

    
    public function installed($id) {
        $package = $this->getAll()[$id];
        return file_exists($this->appDirectory . 'packages/' . $package->base_path . '/' . $package->source_path . '/' . str_replace([$package->namespace, '\\'], ['','/'], $package->providers[0]) . '.php');
    }

    
    public function autoload($className)
    {
        foreach ($this->getInstalled() as $package) {
            
            $static = (array) $package->static;

            
            if (in_array($className, array_keys($static))) {
                $classPath = __DIR__ . '/../../packages/' . $package->base_path . '/' . $static[$className] . '/' . $className . '.php';
                include_once $classPath;
                
            } elseif (strpos($className, $package->namespace) !== FALSE) {
                $classPath = __DIR__ . '/../../packages/' . $package->base_path . '/' . $package->source_path . '/' . str_replace([$package->namespace, '\\'], ['','/'], $className) . '.php';
                include_once $classPath;
            }
        }

    }
}