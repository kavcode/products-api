<?php declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Order;
use App\Exceptions\ItemNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class OrderRepository
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function getById(int $id): Order
    {
        $result =  $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from(Order::class, 'o')
            ->where('o.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$result) {
            throw new ItemNotFoundException("Order with ID {$id} not found");
        }

        return $result;
    }
}