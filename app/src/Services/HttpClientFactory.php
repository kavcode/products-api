<?php declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class HttpClientFactory
{
    public function create(
        string $host
    ) : Client
    {
        return new Client([
            'base_uri' => $host
        ]);
    }
}