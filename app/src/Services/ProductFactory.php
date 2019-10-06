<?php declare(strict_types=1);

namespace App\Services;

use App\Entities\Product;

class ProductFactory
{
    public function create(
        string $name,
        int $price
    ) : Product
    {
        return new Product($name, $price);
    }
}