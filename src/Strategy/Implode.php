<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

namespace SkuBuilder\Strategy;

use SkuBuilder\Strategy;

class Implode implements Strategy
{
    private $separator;

    public function __construct($separator = '-')
    {
        $this->separator = $separator;
    }
    public function execute(array $data)
    {
        return implode($data, $this->separator);
    }
}
