<?php


namespace Small\Router;


use Psr\Container\ContainerInterface;
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

class Dispatcher implements MiddlewareAwareInterface, RequestHandlerInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    use MiddlewareAwareTrait;

    /**
     * @var array<Route> Array of route objects that match the request URI (lazy-loaded)
     */
    protected array $routes = [];

    /**
     * @var array<Route> Array of route objects that match the request URI (lazy-loaded)
     */
    protected array $matchedRoutes = [];

    /**
     * Dispatcher constructor.
     * @param Route[] $routes
     * @param ContainerInterface $container
     */
    public function __construct(array $routes, ContainerInterface $container)
    {
        $this->routes = $routes;
        $this->setContainer($container);
    }

    public function dispatchRequest(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->getMiddlewares() as $key => $middleware) {
            $this->middleware($this->resolveMiddleware($middleware));
        }

        $method = $request->getMethod();
        $pathInfo = $request->getUri()->getPath();
        $matchedRoutes = $this->getMatchedRoutes($method, $pathInfo);
        $route = $matchedRoutes[0];

        foreach ($route->getMiddlewares() as $key => $middleware) {
            $this->middleware($this->resolveMiddleware($middleware));
        }

        // add actual route to end of stack
        $this->middleware($route);

        return $this->handle($request);
    }

    /**
     * Return route objects that match the given HTTP method and URI
     * @param  string               $httpMethod   The HTTP method to match against
     * @param  string               $resourceUri  The resource URI to match against
     * @return array<Route>
     */
    public function getMatchedRoutes($httpMethod, $resourceUri): array
    {
        if (empty($this->matchedRoutes)) {
            $this->matchedRoutes = array();
            foreach ($this->routes as $route) {
                if ($route->matches($resourceUri)) {
                    $this->matchedRoutes[] = $route;
                }
            }
        }

        return $this->matchedRoutes;
    }

    /**
     * @inheritDoc
     */public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->shiftMiddleware();

        if ($middleware instanceof ContainerAwareInterface)
            $middleware->setContainer($this->getContainer());

        return $middleware->process($request, $this);
    }
}