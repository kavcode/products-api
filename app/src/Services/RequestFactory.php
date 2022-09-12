<?php declare(strict_types=1);

namespace App\Services;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;

class RequestFactory
{
    public function create(): ServerRequest
    {
        return ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
    }
}