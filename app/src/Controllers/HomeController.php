<?php declare(strict_types=1);

namespace App\Controllers;

use Zend\Diactoros\ServerRequest;

class HomeController
{
    public function __invoke(ServerRequest $request)
    {
        return 'Try GET /init';
    }
}