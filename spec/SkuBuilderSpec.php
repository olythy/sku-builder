<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

namespace spec\SkuBuilder;

use SkuBuilder\SkuBuilder;
use SkuBuilder\Strategy\Pattern;
use SkuBuilder\Formatter\Replace;
use SkuBuilder\Formatter\Uppercase;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SkuBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SkuBuilder::class);
    }

    function it_should_have_sku_method()
    {
        $this->sku([]);
    }

    function it_should_use_pattern_strategy()
    {
        $strategy = new Pattern('{prefix}-MODEL|{option}');
        $this->beConstructedWith($strategy);
        $data = [
            'prefix' => 'SKU',
            'option' => 1
        ];
        $this->sku($data)->shouldBe('SKU-MODEL|1');
    }

    function it_should_be_formatted_by_replace_formatter()
    {
        $formatter = new Replace(['SKU' => 'S']);
        $data = [
            'prefix' => 'SKU',
            'option' => 1
        ];
        $this->beConstructedWith(null, $formatter);
        $this->sku($data)->shouldBe('S-1');
    }

    function it_should_be_formatted_by_multiple_formatter()
    {
        $formatters = [
            [ Replace::class => [ 'replace' => [ 'SKU' => 's', 's-' => 's' ] ] ],
            [ Uppercase::class ]
        ];
        $data = [
            'prefix' => 'SKU',
            'option' => 1
        ];
        $this->beConstructedWith(null, $formatters);
        $this->sku($data)->shouldBe('S1');
    }

    function it_should_create_by_config()
    {
        $config = [
            'strategy' => [ Pattern::class => [ 'pattern' => '{prefix}-{increment}|{option}', 'mode' => Pattern::MODE_LOOSE ] ],
            'formatters' => [
                [ Replace::class => [ 'replace' => [ '-\|' => 'default-sku' ] ] ],
                [ Uppercase::class ]
            ]
        ];
        $this->beConstructedThrough('createByConfig', [ $config ]);
        // var_dump('Count', count($this->getFormatters()));
        $this->sku([ 'no' => 'NO', 'data' => 'DATA' ])->shouldBe('DEFAULT-SKU');
    }

    function it_should_not_allow_to_add_invalid_formatter()
    {
        $formatter = new \stdClass();
        $this->shouldThrow('\InvalidArgumentException')->duringAddFormatter($formatter);
    }
}
