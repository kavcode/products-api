<?php declare(strict_types=1);

namespace App\Services;

use App\Entities\Order;
use App\Entities\OrderStatus;
use App\Repositories\OrderStatusRepository;

class OrderFactory
{
    private $statusRepository;
    private $userProvider;

    public function __construct(
        OrderStatusRepository $statusRepository,
        UserProvider $userProvider
    )
    {
        $this->statusRepository = $statusRepository;
        $this->userProvider = $userProvider;
    }

    public function create(): Order
    {
        return new Order(
            $this->statusRepository->getById(OrderStatus::CREATED),
            $this->userProvider->getCurrentUser()->getId()
        );
    }
}