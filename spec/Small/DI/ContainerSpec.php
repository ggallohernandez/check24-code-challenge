<?php

namespace spec\Small\DI;

use PhpSpec\ObjectBehavior;
use Small\DI\Container;

class ContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Container::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement('Psr\Container\ContainerInterface');
    }

    function it_has_simple_classes()
    {
        $this->has('DateTime')->shouldReturn(true);
    }

    function it_does_not_have_unknown_classes()
    {
        $this->has('UnknownClass')->shouldReturn(false);
    }

    function it_can_get_simple_classes()
    {
        $this->get('DateTime')->shouldReturnAnInstanceOf('DateTime');
    }

    function it_returns_not_found_exception_if_class_cannot_be_found()
    {
        $this->shouldThrow('Small\DI\Exceptions\NotFoundException')
            ->duringGet('UnknownClass');
    }
}
