<?php

require_once __DIR__.'/../bootstrap/app.php';

$container = include __DIR__.'/../bootstrap/container.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;

$appEnv = getenv('APP_ENV');

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$responseFactory = new \Laminas\Diactoros\ResponseFactory();

/**
 * @var \Small\Router\Router $router
 */
$router = include __DIR__ . '/../routes/web.php';

$router->setContainer($container);

$response = $router->handle($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
