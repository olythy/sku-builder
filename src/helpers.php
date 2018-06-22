<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

namespace SkuBuilder;

if (!function_exists('instance')) {

    function instance($objData)
    {
        $obj = null;
        if (is_array($objData)) {
            $class = key($objData);
            $objData = current($objData);
            $reflector = new \ReflectionClass($class);
            $obj = $reflector->newInstanceArgs($objData);
        } elseif (is_string($objData)) {
            $obj = new $objData;
        }
        return $obj;
    }

}
