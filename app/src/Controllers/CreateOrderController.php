<?php declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\BadRequestException;
use App\Repositories\ProductRepository;
use App\Services\OrderFactory;
use App\Services\ResponseFactory;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\ServerRequest;

class CreateOrderController
{
    private $productRepository;
    private $orderFactory;
    private $entityManager;

    public function __construct(
        ProductRepository $productRepository,
        OrderFactory $orderFactory,
        EntityManager $entityManager
    )
    {
        $this->productRepository = $productRepository;
        $this->orderFactory = $orderFactory;
        $this->entityManager = $entityManager;
    }

    public function __invoke(ServerRequest $request)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        if (!isset($data['products']) || !$data['products']) {
            throw new BadRequestException('At least one product id is required');
        }

        $order = $this->orderFactory->create();
        $products = $this->productRepository->findByIds($data['products']);
        if (!$products) {
            throw new BadRequestException('Can\'t find any product for given ids');
        }

        foreach ($products as $product) {
            $order->addProduct($product);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return [
            'id' => $order->getId(),
            'sum' => $order->getTotalPrice()
        ];
    }
}