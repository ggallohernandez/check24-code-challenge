<?php


namespace Small\Router\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

trait MiddlewareAwareTrait
{
    /**
     * @var array<MiddlewareInterface>
     */
    protected array $middleware = [];

    /**
     * {@inheritdoc}
     */
    public function middleware(MiddlewareInterface $middleware): MiddlewareAwareInterface
    {
        $this->middleware[] = $middleware;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function middlewares(array $middlewares): MiddlewareAwareInterface
    {
        foreach ($middlewares as $middleware) {
            $this->middleware($middleware);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function prependMiddleware(MiddlewareInterface $middleware): MiddlewareAwareInterface
    {
        array_unshift($this->middleware, $middleware);

        return $this;
    }

    /**
     * Add a middleware as a class name to the stack
     *
     * @param string $middleware
     *
     * @return MiddlewareAwareInterface
     */
    public function lazyMiddleware(string $middleware): MiddlewareAwareInterface
    {
        $this->middleware[] = $middleware;

        return $this;
    }

    /**
     * Add multiple middlewares as class names to the stack
     *
     * @param string[] $middlewares
     *
     * @return MiddlewareAwareInterface
     */
    public function lazyMiddlewares(array $middlewares): MiddlewareAwareInterface
    {
        foreach ($middlewares as $middleware) {
            $this->lazyMiddleware($middleware);
        }

        return $this;
    }

    /**
     * Prepend a middleware as a class name to the stack
     *
     * @param string $middleware
     *
     * @return MiddlewareAwareInterface
     */
    public function lazyPrependMiddleware(string $middleware): MiddlewareAwareInterface
    {
        array_unshift($this->middleware, $middleware);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function shiftMiddleware(): MiddlewareInterface
    {
        $middleware =  array_shift($this->middleware);

        if ($middleware === null) {
            throw new \OutOfBoundsException('Reached end of middleware stack. Does your controller return a response?');
        }

        return $middleware;
    }

    /**
     * {@inheritdoc}
     */
    public function getMiddlewares(): iterable
    {
        return $this->middleware;
    }

    /**
     * Resolve a middleware implementation, optionally from a container
     *
     * @param MiddlewareInterface|string $middleware
     * @param ContainerInterface|null    $container
     *
     * @return MiddlewareInterface
     */
    protected function resolveMiddleware(MiddlewareInterface|string $middleware, ?ContainerInterface $container = null): MiddlewareInterface
    {
        if ($container === null && is_string($middleware) && class_exists($middleware)) {
            $middleware = new $middleware;
        }

        if ($container !== null && is_string($middleware) && $container->has($middleware)) {
            $middleware = $container->get($middleware);
        }

        if ($middleware instanceof MiddlewareInterface) {
            return $middleware;
        }

        throw new \InvalidArgumentException(sprintf('Could not resolve middleware class: %s', $middleware));
    }
}
