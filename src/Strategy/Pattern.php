<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

namespace SkuBuilder\Strategy;

use SkuBuilder\Strategy;

class Pattern implements Strategy
{
    const MODE_STRICT = 'strict';
    const MODE_LOOSE ='loose';

    private $pattern;
    private $mode;

    public function __construct($pattern, $mode = null)
    {
        $this->pattern = $pattern;
        $this->mode = $mode ?: self::MODE_STRICT;
    }

    public function execute(array $data)
    {
        $result = $this->pattern;
        foreach ($data as $key => $value) {
            $key = is_numeric($key) ? "index{$key}" : $key;
            $pattern = "/{\s*$key\s*}/";
            $result = preg_replace($pattern, $value, $result);
        }
        $pattern = '/{[^}]*}/';
        if ($this->mode == self::MODE_STRICT && preg_match($pattern, $result, $matches)) {
            throw new \InvalidArgumentException("Can not parse variable {$matches[0]}");
        }
        $result = preg_replace($pattern, '', $result);

        return $result;
    }
}
