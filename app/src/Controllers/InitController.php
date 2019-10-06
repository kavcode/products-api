<?php declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;
use App\Services\ProductFactory;
use App\Services\ProductSerializer;
use Doctrine\ORM\EntityManager;
use Zend\Diactoros\ServerRequest;

class InitController
{
    private $productRepository;
    private $productFactory;
    private $entityManager;
    private $productSerializer;

    public function __construct(
        ProductRepository $productRepository,
        ProductFactory $productFactory,
        EntityManager $entityManager,
        ProductSerializer $productSerializer
    )
    {
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
        $this->entityManager = $entityManager;
        $this->productSerializer = $productSerializer;
    }

    public function __invoke(ServerRequest $request)
    {
        $result = $this->productRepository->getAll();
        if (!$result) {
            for ($i = 1; $i <= 20; $i++) {
                $product = $this->productFactory->create("Product #{$i}", random_int(100, 1000));
                $this->entityManager->persist($product);
                $result[] = $product;
            }
        }
        $this->entityManager->flush();
        return $this->productSerializer->serialize($result);
    }
}