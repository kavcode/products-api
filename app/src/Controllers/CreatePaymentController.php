<?php declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\BadRequestException;
use App\Repositories\OrderRepository;
use App\Repositories\OrderStatusRepository;
use App\Services\PaymentGate;
use Doctrine\ORM\EntityManager;
use Zend\Diactoros\ServerRequest;

class CreatePaymentController
{
    private $orderRepository;
    private $paymentGate;
    private $orderStatusRepository;
    private $entityManager;

    public function __construct(
        OrderRepository $orderRepository,
        PaymentGate $paymentGate,
        OrderStatusRepository $orderStatusRepository,
        EntityManager $entityManager
    )
    {
        $this->orderRepository = $orderRepository;
        $this->paymentGate = $paymentGate;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(ServerRequest $request)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        if (!isset($data['order_id'])) {
            throw new BadRequestException('Order id must be specified');
        }

        if (!isset($data['sum'])) {
            throw new BadRequestException('Order sum must de specified');
        }

        $order = $this->orderRepository->getById((int) $data['order_id']);
        if (!$order->isNew()) {
            return ['status' => 'failed', 'message' => 'Wrong order status'];
        }

        if ($order->getTotalPrice() !== (int) $data['sum']) {
            return ['status' => 'failed', 'message' => 'Sum mismatch'];
        }

        if (!$this->paymentGate->sendRequest()) {
            return ['status' => 'failed', 'message' => 'Failed request to payment gateway'];
        }

        $order->pay($this->orderStatusRepository);
        $this->entityManager->flush();
        return ['status' => 'success'];
    }
}