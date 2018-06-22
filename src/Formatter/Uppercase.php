<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

namespace SkuBuilder\Formatter;

use SkuBuilder\Formatter;

class Uppercase implements Formatter
{
    public function format($string)
    {
        return strtoupper($string);
    }
}