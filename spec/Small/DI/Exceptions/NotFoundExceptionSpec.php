<?php

namespace spec\Small\DI\Exceptions;

use PhpSpec\ObjectBehavior;
use Small\DI\Exceptions\NotFoundException;

class NotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NotFoundException::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement('Psr\Container\NotFoundExceptionInterface');
    }
    function it_implements_throwable()
    {
        $this->shouldImplement('Throwable');
    }
}
