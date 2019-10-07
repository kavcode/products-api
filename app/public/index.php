<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use \App\Services\Container;

$container = new Container(
    require_once __DIR__ . '/../config.php',
);

$container
    ->define('RequestFactory', function (Container $container) {
        return new \App\Services\RequestFactory();
    })
    ->define('Request', function (Container $container) {
        return $container->get('RequestFactory')->create();
    })
    ->define('ResponseFactory', function (Container $container) {
        return new \App\Services\ResponseFactory();
    })
    ->define('RequestContextFactory', function (Container $container) {
        return new \App\Services\RequestContextFactory();
    })
    ->define('Router', function (Container $container) {
        $router = new \App\Services\Router();
        $router->addRoute('home', 'GET', '/', \App\Controllers\HomeController::class);
        $router->addRoute('init', 'GET', '/init', \App\Controllers\InitController::class);
        $router->addRoute('products', 'GET', '/products', \App\Controllers\ProductListController::class);
        $router->addRoute('create_order', 'POST', '/orders', \App\Controllers\CreateOrderController::class);
        $router->addRoute('create_payment', 'POST', '/payments', \App\Controllers\CreatePaymentController::class);
        return $router;
    })
    ->define('Dispatcher', function (Container $container) {
        return new \App\Services\Dispatcher(
            $container->get('RequestContextFactory')->create(
                $container->get('Request')
            ),
            $container->get('Router')->getRoutes(),
            $container,
            $container->get('ResponseFactory')
        );
    })
    ->define('EntityManager', function (Container $container) {
        return (new \App\Services\EntityManagerFactory($container))->create();
    })
    ->define('HttpClientFactory', function (Container $container) {
        return new \App\Services\HttpClientFactory();
    })
    ->define('PaymentGate', function (Container $container) {
        return new \App\Services\PaymentGate(
            $container->get('HttpClientFactory')
        );
    })
    ->define('ProductSerializer', function (Container $container) {
        return new \App\Services\ProductSerializer();
    })
    ->define('ProductRepository', function (Container $container) {
        return new \App\Repositories\ProductRepository($container->get('EntityManager'));
    })
    ->define('OrderStatusRepository', function (Container $container) {
        return new \App\Repositories\OrderStatusRepository($container->get('EntityManager'));
    })
    ->define('OrderRepository', function (Container $container) {
        return new \App\Repositories\OrderRepository($container->get('EntityManager'));
    })
    ->define('ProductFactory', function (Container $container) {
        return new \App\Services\ProductFactory();
    })
    ->define('UserProvider', function (Container $container) {
        return new \App\Services\UserProvider();
    })
    ->define('OrderFactory', function (Container $container) {
        return new \App\Services\OrderFactory(
            $container->get('OrderStatusRepository'),
            $container->get('UserProvider')
        );
    })
    ->define(\App\Controllers\HomeController::class, function (Container $container) {
        return new \App\Controllers\HomeController();
    })
    ->define(\App\Controllers\InitController::class, function (Container $container) {
        return new \App\Controllers\InitController(
            $container->get('ProductRepository'),
            $container->get('ProductFactory'),
            $container->get('EntityManager'),
            $container->get('ProductSerializer')
        );
    })
    ->define(\App\Controllers\ProductListController::class, function (Container $container) {
        return new \App\Controllers\ProductListController(
            $container->get('ProductRepository'),
            $container->get('ProductSerializer')
        );
    })
    ->define(\App\Controllers\CreateOrderController::class, function (Container $container) {
        return new \App\Controllers\CreateOrderController(
            $container->get('ProductRepository'),
            $container->get('OrderFactory'),
            $container->get('EntityManager')
        );
    })
    ->define(\App\Controllers\CreatePaymentController::class, function (Container $container) {
        return new \App\Controllers\CreatePaymentController(
            $container->get('OrderRepository'),
            $container->get('PaymentGate'),
            $container->get('OrderStatusRepository'),
            $container->get('EntityManager')
        );
    })
;

/** @var \App\Services\Dispatcher $dispatcher */
$dispatcher = $container->get('Dispatcher');
$response = $dispatcher->dispatch($container->get('Request'));
(new \Zend\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);