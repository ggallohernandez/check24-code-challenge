<?php

namespace Small\DI;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Small\DI\Exceptions\NotFoundException;

/**
 * PSR-11 compatible DI container
 * @package Small\DI
 */
class Container implements ContainerInterface
{
    protected array $services = [];

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        return $this->services[$id] ??
            $this->getInstance($this->resolve($id))
        ;
    }

    /**
     * @inheritDoc
     */
    public function has($id)
    {
        if (isset($this->services[$id])) {
            return true;
        }

        try {
            $item = $this->resolve($id);
        } catch (NotFoundException $e) {
            return false;
        }
        return $item->isInstantiable();
    }

    public function set(string $id, ?object $service)
    {
        if (null === $service) {
            unset($this->services[$id]);

            return;
        }

        $this->services[$id] = $service;
    }

    private function resolve($id)
    {
        try {
            return (new \ReflectionClass($id));
        } catch (\ReflectionException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getInstance(\ReflectionClass $item)
    {
        return $item->newInstance();
    }
}
