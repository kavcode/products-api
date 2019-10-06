<?php declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Product[]
     */
    public function getAll(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('product')
            ->from(Product::class, 'product')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $ids
     * @return Product[]
     */
    public function findByIds(array $ids): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('product')
            ->from(Product::class, 'product')
            ->where('product.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }
}