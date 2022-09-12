<?php declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;
use App\Services\ProductSerializer;
use Laminas\Diactoros\ServerRequest;

class ProductListController
{
    private $productRepository;
    private $productSerializer;

    public function __construct(
        ProductRepository $productRepository,
        ProductSerializer $productSerializer
    )
    {
        $this->productRepository = $productRepository;
        $this->productSerializer = $productSerializer;
    }

    public function __invoke(ServerRequest $request)
    {
        return $this->productSerializer->serialize(
            $this->productRepository->getAll()
        );
    }
}