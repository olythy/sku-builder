<?php

/**
 * @copyright  Copyright (c) 2018 OlyThy <olythy@gmail.com>
 * @license    http://opensource.org/licenses/mit-license.php  The MIT License
 */

namespace spec\SkuBuilder\Formatter;

use SkuBuilder\Formatter\Replace;
use SkuBuilder\Formatter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReplaceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldImplement(Formatter::class);
        $this->shouldHaveType(Replace::class);
    }

    function it_should_have_method_format()
    {
        $this->format('');
    }

    function it_should_be_formatted()
    {
        $this->beConstructedWith([
            'SKU' => 'S'
        ]);
        $this->format('SKU-1')->shouldBe('S-1');
    }
}
