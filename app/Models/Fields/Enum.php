<?php
/**
 *   Crypto Trading Competitions
 *   ---------------------------
 *   Enum.php
 * 
 *   @copyright  Copyright (c) FinancialPlugins, All rights reserved
 *   @author     FinancialPlugins <info@financialplugins.com>
 *   @see        https://financialplugins.com
*/

namespace App\Models\Fields;

trait Enum
{
    
    public static function getEnumValues($fieldName) {
        $modelClass = new \ReflectionClass(get_called_class());
        $implementedInterfaces = $modelClass->getInterfaces();
        $enumInterfaceName = __NAMESPACE__ . '\\Enum' . $fieldName;

        return isset($implementedInterfaces[$enumInterfaceName])
            ? array_values($implementedInterfaces[$enumInterfaceName]->getConstants())
            : [];
    }
}