<?php declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Routing\RequestContext;
use Zend\Diactoros\ServerRequest;

class RequestContextFactory
{
    public function create(ServerRequest $request): RequestContext
    {
        return new \Symfony\Component\Routing\RequestContext(
            '/',
            $request->getMethod(),
            $request->getUri()->getHost(),
            $request->getUri()->getScheme(),
            80,
            443,
            $request->getUri()->getPath(),
            $request->getUri()->getQuery()
        );
    }
}