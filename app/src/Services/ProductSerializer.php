<?php declare(strict_types=1);

namespace App\Services;

use App\Entities\Product;

class ProductSerializer
{
    /**
     * @param Product[] $products
     * @return array
     */
    public function serialize(array $products): array
    {
        $result = [];
        foreach ($products as $product) {
            /** @var \App\Entities\Product $product */
            $result[] = [
                'id'    => $product->getId(),
                'name'  => $product->getName(),
                'price' => $product->getPrice()
            ];
        }
        return $result;
    }
}