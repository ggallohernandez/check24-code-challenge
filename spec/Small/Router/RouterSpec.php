<?php

namespace spec\Small\Router;

use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Small\Router\Router;

class RouterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Router::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement('Psr\Http\Server\RequestHandlerInterface');
    }

    function it_should_route_basic_stuff() {
        $this->map('GET', '/home', function(ServerRequestInterface $request) : ResponseInterface {
            return new Response('Hello world!');
        });

        $request = new ServerRequest([], [], '/home', 'GET');

        $response = $this->dispatch($request);
        $response->shouldBeAnInstanceOf(ResponseInterface::class);
        $response->getStatusCode()->shouldBeEqualTo(200);
        $response->getBody()->getMetadata('uri')->shouldBeEqualTo('Hello world!');
    }

    function it_should_route_basic_placeholders_replacement_stuff() {
        $this->map('GET', '/user/:id', function(ServerRequestInterface $request, $params) : ResponseInterface {
            return new Response("{$params['id']}");
        });

        $request = new ServerRequest([], [], '/user/2', 'GET');

        $response = $this->dispatch($request);
        $response->shouldBeAnInstanceOf(ResponseInterface::class);
        $response->getStatusCode()->shouldBeEqualTo(200);
        $response->getBody()->getMetadata('uri')->shouldBeEqualTo('2');
    }

    function it_should_route_more_serious_placeholders_replacement_stuff() {
        $this->map('GET', '/user/:id/sendnews/:resp', function(ServerRequestInterface $request, $params) : ResponseInterface {
            return new Response("{$params['id']}-{$params['resp']}");
        });

        $request = new ServerRequest([], [], '/user/2/sendnews/1', 'GET');

        $response = $this->dispatch($request);
        $response->shouldBeAnInstanceOf(ResponseInterface::class);
        $response->getStatusCode()->shouldBeEqualTo(200);
        $response->getBody()->getMetadata('uri')->shouldBeEqualTo('2-1');
    }

    function it_should_support_middlewares() {
        $exceptionMiddleware = new class implements \Psr\Http\Server\MiddlewareInterface
        {
            /**
             * {@inheritdoc}
             */
            public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler) : ResponseInterface
            {
                try {
                    $response = $handler->handle($request);
                } catch (\InvalidArgumentException $e) {
                    $response = (new Response())
                        ->withStatus(422)
                    ;

                    $response->getBody()->write($e->getMessage());
                } catch (\Throwable $e) {
                    $response = (new Response())
                        ->withStatus(500)
                    ;

                    $response->getBody()->write($e->getMessage());
                } finally {
                    return $response;
                }
            }
        };

        $this->middleware($exceptionMiddleware);

        $this->map('GET', '/ok', function(ServerRequestInterface $request) : ResponseInterface {
            return new Response('ok');
        });
        $this->map('GET', '/wrong', function(ServerRequestInterface $request) : ResponseInterface {
            throw new \InvalidArgumentException("wrong");
        });
        $this->map('GET', '/bad', function(ServerRequestInterface $request) : ResponseInterface {
            throw new \Exception("bad");
        });

        $request = new ServerRequest([], [], '/ok', 'GET');

        $response = $this->dispatch($request);
        $response->shouldBeAnInstanceOf(ResponseInterface::class);
        $response->getStatusCode()->shouldBeEqualTo(200);
        $response->getBody()->getMetadata('uri')->shouldBeEqualTo('ok');

        $request = new ServerRequest([], [], '/wrong', 'GET');

        $response = $this->dispatch($request);
        $response->shouldBeAnInstanceOf(ResponseInterface::class);
        $response->getStatusCode()->shouldBeEqualTo(422);

        $request = new ServerRequest([], [], '/bad', 'GET');

        $response = $this->dispatch($request);
        $response->shouldBeAnInstanceOf(ResponseInterface::class);
        $response->getStatusCode()->shouldBeEqualTo(500);
        $response->getBody()->getMetadata('uri')->shouldBeEqualTo('bad');
    }
}
