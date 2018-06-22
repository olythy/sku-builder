<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

namespace SkuBuilder\Formatter;

use SkuBuilder\Formatter;

class Replace implements Formatter
{
    private $replace;

    public function __construct(array $replace = [])
    {
        $this->replace = $replace;
    }

    public function format($string)
    {
        foreach ($this->replace as $from => $to) {
            if ($from[0] !== '/') {
                $from = "/$from/";
            }
            $string = preg_replace($from, $to, $string);
        }

        return $string;
    }
}
