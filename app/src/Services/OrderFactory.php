<?php declare(strict_types=1);

namespace App\Services;

use App\Entities\Order;
use App\Entities\OrderStatus;
use App\Repositories\OrderStatusRepository;

class OrderFactory
{
    private $statusRepository;

    public function __construct(
        OrderStatusRepository $statusRepository
    )
    {
        $this->statusRepository = $statusRepository;
    }

    public function create(): Order
    {
        return new Order(
            $this->statusRepository->getById(OrderStatus::CREATED)
        );
    }
}