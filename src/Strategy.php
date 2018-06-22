<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

namespace SkuBuilder;

interface Strategy
{
    public function execute(array $data);
}
