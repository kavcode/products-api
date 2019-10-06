<?php declare(strict_types=1);

namespace App\Services;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory;

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