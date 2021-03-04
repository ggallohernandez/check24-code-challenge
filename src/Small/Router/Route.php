<?php

namespace Small\Router;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Small\DI\ContainerAwareInterface;
use Small\DI\ContainerAwareTrait;
use Small\Router\Middleware\MiddlewareAwareInterface;
use Small\Router\Middleware\MiddlewareAwareTrait;

class Route implements MiddlewareInterface, MiddlewareAwareInterface, ContainerAwareInterface
{
    use MiddlewareAwareTrait;
    use ContainerAwareTrait;

    /**
     * @var callable|string
     */
    protected $handler;
    protected string $method;
    protected string $path;

    /**
     * @var array
     */
    protected array $vars = [];

    /**
     * @var array
     */
    protected array $varNames = [];

    /**
     * @var array
     */
    protected array $varNamesPath = [];

    /**
     * @var array
     */
    protected array $conditions = [];


    public function __construct(string $method, string $path, callable|string $handler)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
    }

    public function matches(string $resourceUri): bool
    {
        //Convert URL params into regex patterns, construct a regex for this route, init params
        $patternAsRegex = preg_replace_callback(
            '#:([\w]+)\+?#',
            array($this, 'matchesCallback'),
            str_replace(')', ')?', (string)$this->path)
        );
        if (substr($this->path, -1) === '/') {
            $patternAsRegex .= '?';
        }

        $regex = '#^' . $patternAsRegex . '$#';

        //Cache URL params' names and values if this route matches the current HTTP request
        if (!preg_match($regex, $resourceUri, $paramValues)) {
            return false;
        }
        foreach ($this->varNames as $name) {
            if (isset($paramValues[$name])) {
                if (isset($this->varNamesPath[$name])) {
                    $this->vars[$name] = explode('/', urldecode($paramValues[$name]));
                } else {
                    $this->vars[$name] = urldecode($paramValues[$name]);
                }
            }
        }

        return true;
    }

    /**
     * Convert a URL parameter (e.g. ":id", ":id+") into a regular expression
     * @param array $placeholders URL parameters
     * @return string Regular expression for URL parameter
     */
    protected function matchesCallback(array $placeholders): string
    {
        $this->varNames[] = $placeholders[1];
        if (isset($this->conditions[$placeholders[1]])) {
            return '(?P<' . $placeholders[1] . '>' . $this->conditions[$placeholders[1]] . ')';
        }
        if (substr($placeholders[0], -1) === '+') {
            $this->varNamesPath[$placeholders[1]] = 1;

            return '(?P<' . $placeholders[1] . '>.+)';
        }

        return '(?P<' . $placeholders[1] . '>[^/]+)';
    }

    /**
     * Get the controller callable
     *
     * @param ContainerInterface|null $container
     *
     * @return callable
     *
     * @throws \InvalidArgumentException
     */
    public function getCallable(?ContainerInterface $container = null): callable
    {
        $callable = $this->handler;

        if (is_string($callable) && strpos($callable, '::') !== false) {
            $callable = explode('::', $callable);
        }

        if (is_array($callable) && isset($callable[0]) && is_object($callable[0])) {
            $callable = [$callable[0], $callable[1]];
        }

        if (is_array($callable) && isset($callable[0]) && is_string($callable[0])) {
            $callable = [$this->resolveClass($container, $callable[0]), $callable[1]];
        }

        if (is_string($callable) && method_exists($callable, '__invoke')) {
            $callable = $this->resolveClass($container, $callable);
        }

        if (!is_callable($callable)) {
            throw new \InvalidArgumentException('Could not resolve a callable for this route');
        }

        return $callable;
    }

    /**
     * Get an object instance from a class name
     *
     * @param ContainerInterface|null $container
     * @param string $class
     *
     * @return object
     */
    protected function resolveClass(?ContainerInterface $container, string $class): object
    {
        if ($container instanceof ContainerInterface && $container->has($class)) {
            return $container->get($class);
        }

        return new $class();
    }


    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $controller = $this->getCallable($this->getContainer());

        if ($controller instanceof ContainerAwareInterface)
            $controller->setContainer($this->getContainer());

        $response = $controller($request, $this->vars);

        return $response;
    }
}