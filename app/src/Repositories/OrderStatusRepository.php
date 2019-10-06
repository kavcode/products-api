<?php declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Order;
use App\Entities\OrderStatus;
use App\Exceptions\ItemNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class OrderStatusRepository
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function getById(int $id): ?OrderStatus
    {
        $entity = $this->entityManager->createQueryBuilder()
            ->select('status')
            ->from(OrderStatus::class, 'status')
            ->where('status.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$entity) {
            throw new ItemNotFoundException("Order status with ID {$id} not found");
        }

        return $entity;
    }
}