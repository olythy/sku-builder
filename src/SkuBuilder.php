<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

namespace SkuBuilder;

use SkuBuilder\Strategy;
use SkuBuilder\Formatter;
use SkuBuilder\Strategy\Implode;

final class SkuBuilder
{
    private $strategy;

    protected $formatters = [];

    public function __construct(Strategy $strategy = null, $formatter = null)
    {
        $strategy = $strategy ?: new Implode;
        $this->strategy = $strategy;

        if (!is_null($formatter)) {
            $this->addFormatter($formatter);
        }
    }

    public static function createByConfig(array $config)
    {
        $strategy = isset($config['strategy']) ? instance($config['strategy']) : null;
        $formatters = isset($config['formatters']) ? $config['formatters'] : null;
        return new self($strategy, $formatters);
    }


    public function getFormatters()
    {
        return $this->formatters;
    }


    public function sku($data, $params = null)
    {
        $sku = '';
        if ($params instanceof Closure) {
            $sku = $params->call($data);
        } else {
            $sku = $this->strategy->execute($data, $params);
        }
        $sku = $this->format($sku);
        $sku = ascii($sku);

        return $sku;
    }

    public function addFormatter($formatter)
    {
        if (is_array($formatter) && isset($formatter[0]) && is_array($formatter[0])) {
            return array_map([$this, 'addFormatter'], $formatter);
        } elseif (is_array($formatter)) {
            $formatter = isset($formatter[0]) ? $formatter[0] : $formatter;
            $formatter = instance($formatter);
        } elseif (is_string($formatter)) {
            $formatter = instance($formatter);
        }

        if (!is_object($formatter)) {
            throw new \InvalidArgumentException("Invalid formatter");
        }

        if (!($formatter instanceof Formatter)) {
            $class = get_class($formatter);
            throw new \InvalidArgumentException("Invalid formatter, it must be drived by {$class}");
        }

        $this->formatters[] = $formatter;

        return $this;
    }

    private function format($sku)
    {
        $sku = array_reduce($this->formatters, function ($sku, $formatter) {
            return $formatter->format($sku);
        }, $sku);

        return $sku;
    }
}
