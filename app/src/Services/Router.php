<?php declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    private $routes;
    
    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    public function addRoute(
        string $name,
        string $method,
        string $path,
        string $controller
    ) : void
    {
        $this->routes->add(
            $name,
            new Route(
                $path,
                ['_controller' => $controller],
                [],
                [],
                null,
                [],
                [$method]
            )
        );
    }

    public function getRoutes(): RouteCollection
    {
        return $this->routes;
    }
}