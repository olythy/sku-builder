<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use SkuBuilder\SkuBuilder;
use SkuBuilder\Strategy\Implode;
use SkuBuilder\Strategy\Pattern;

final class SkuBuilderTest extends TestCase
{
    public function testImplodeStrategy()
    {
        $items = [
            [
                'data' => ['SKU', 1],
                'expected' => 'SKU|1',
                'separator' => '|'
            ]
        ];
        foreach ($items as $item) {
            extract($item);
            $strategy = new Implode($separator);
            $builder = new SkuBuilder($strategy);
            $result = $builder->sku($data);
            $this->assertEquals($expected, $result, vsprintf('Test %s with separator "%s"', [json_encode($data), $separator]));
        }
    }

    public function testPatternStrategy()
    {
        $items = [
            [
                'data' => ['SKU', 1],
                'expected' => 'SKU|1',
                'pattern' => '{index0}|{index1}',
                'mode' => Pattern::MODE_STRICT
            ],
            [
                'data' => ['SKU', 1],
                'expected' => 'SKU|1-',
                'pattern' => '{index0}|{index1}-{index2}',
                'mode' => Pattern::MODE_LOOSE
            ]
        ];
        foreach ($items as $item) {
            extract($item);
            $strategy = new Pattern($pattern, $mode);
            $builder = new SkuBuilder($strategy);
            $result = $builder->sku($data);
            $this->assertEquals($expected, $result, vsprintf('Test %s with pattern "%s"', [json_encode($data), $pattern]));
        }
    }

    public function testStrategyPatternStrict()
    {
        $this->expectException(\InvalidArgumentException::class);
        $strategy = new Pattern('{index0}|{index1}-{index2}');
        $builder = new SkuBuilder($strategy);
        $builder->sku(['SKU', 1]);
    }
}
