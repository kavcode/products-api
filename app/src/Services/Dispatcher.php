<?php declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class Dispatcher
{
    private $urlMatcher;
    private $container;
    private $responseFactory;

    public function __construct(
        RequestContext $requestContext,
        RouteCollection $routes,
        Container $container,
        ResponseFactory $responseFactory
    )
    {
        $this->urlMatcher = new UrlMatcher($routes, $requestContext);
        $this->container = $container;
        $this->responseFactory = $responseFactory;
    }

    public function dispatch(ServerRequest $request): Response
    {
        try {
            $match = $this->urlMatcher->match($request->getUri()->getPath());
        } catch (ResourceNotFoundException $exception) {
            $response = $this->responseFactory->create();
            $response->getBody()->write($exception->getMessage());
            return $response->withStatus(404);
        }

        $controller = $this->container->get($match['_controller']);
        if (!is_callable($controller)) {
            throw new \RuntimeException("Controller $controller must be callable");
        }

        $result = $controller($request);
        if ($result instanceof Response) {
            return $result;
        }

        if (is_string($result)) {
            $response =  $this->responseFactory->create();
            $response->getBody()->write($result);
            return $response->withHeader('Content-Type', 'text/html');
        }

        if (is_array($result)) {
            $response =  $this->responseFactory->create();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json');
        }

        throw new \RuntimeException("Controller $controller has returned bad result");
    }
}