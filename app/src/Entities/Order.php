<?php declare(strict_types=1);

namespace App\Entities;

use App\Repositories\OrderStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="OrderStatus")
     * @ORM\JoinColumn(fieldName="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="order_products",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     * )
     */
    private $products;

    public function __construct(
        OrderStatus $status
    )
    {
        $this->status = $status;
        $this->products = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isNew(): bool
    {
        return $this->status->getId() === OrderStatus::CREATED;
    }

    public function addProduct(
        Product $product
    ) : void
    {
        $this->products->add($product);
    }

    public function getTotalPrice(): int
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }
        return $total;
    }

    public function pay(
        OrderStatusRepository $repository
    ) : void
    {
        if ($this->status->getId() !== OrderStatus::CREATED) {
            throw new \DomainException('Order has wrong status');
        }

        $this->status = $repository->getById(OrderStatus::PAYED);
    }
}