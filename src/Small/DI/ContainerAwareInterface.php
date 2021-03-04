<?php


namespace Small\DI;


use Psr\Container\ContainerInterface;

interface ContainerAwareInterface
{
    /**
     * Get the current container
     *
     * @return ContainerInterface|null
     */
    public function getContainer(): ?ContainerInterface;

    /**
     * Set the container implementation
     *
     * @param ContainerInterface $container
     *
     * @return static
     */
    public function setContainer(ContainerInterface $container): ContainerAwareInterface;
}