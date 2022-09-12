<?php declare(strict_types=1);

namespace App\Services;

use Laminas\Diactoros\Response;

class ResponseFactory
{
    public function create(): Response
    {
        return new Response();
    }
}