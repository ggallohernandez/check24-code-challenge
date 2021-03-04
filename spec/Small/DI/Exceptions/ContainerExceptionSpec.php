<?php

namespace spec\Small\DI\Exceptions;

use PhpSpec\ObjectBehavior;
use Small\DI\Exceptions\ContainerException;

class ContainerExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ContainerException::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement('Psr\Container\ContainerExceptionInterface');
    }

    function it_implements_throwable()
    {
        $this->shouldImplement('Throwable');
    }
}
