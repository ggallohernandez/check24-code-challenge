<?php


namespace Small;


use Small\DI\ContainerAwareInterface;
use Small\DI\ContainerAwareTrait;

abstract class Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;
}