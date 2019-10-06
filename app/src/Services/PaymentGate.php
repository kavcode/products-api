<?php declare(strict_types=1);

namespace App\Services;

class PaymentGate
{
    private $httpClientFactory;

    public function __construct(
        HttpClientFactory $httpClientFactory
    )
    {
        $this->httpClientFactory = $httpClientFactory;
    }

    public function sendRequest(): bool
    {
        $client = $this->httpClientFactory->create('https://ya.ru');
        $result = $client->get('/');
        return $result->getStatusCode() === 200;
    }
}