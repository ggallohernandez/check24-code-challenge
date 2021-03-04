<?php


namespace Small\Router;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Small\DI\ContainerAwareInterface;
use Small\DI\ContainerAwareTrait;
use Small\Router\Middleware\MiddlewareAwareInterface;
use Small\Router\Middleware\MiddlewareAwareTrait;
use Symfony\Component\HttpFoundation\Response;

class Router implements MiddlewareAwareInterface, RequestHandlerInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    use MiddlewareAwareTrait;

    /**
     * @var array<Route>
     */
    protected array $routes = [];

    /**
     * {@inheritdoc}
     */
    public function map(string $method, string $path, $handler): Route
    {
        $path  = sprintf('/%s', ltrim($path, '/'));
        $route = new Route($method, $path, $handler);

        $this->routes[] = $route;

        return $route;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->dispatch($request);
    }

    public function dispatch(ServerRequestInterface $request) : ResponseInterface
    {
        $dispatcher = new Dispatcher($this->routes, $this->getContainer());

        foreach ($this->getMiddlewares() as $middleware) {
            $dispatcher->middleware($middleware);
        }

        return $dispatcher->dispatchRequest($request);
    }
}