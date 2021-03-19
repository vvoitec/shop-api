<?php

declare(strict_types=1);

namespace App\Backend\Cart\Domain;

use App\Common\Domain\AggregateRoot;
use App\Backend\Products\Domain\ProductId;

class Cart extends AggregateRoot
{
    private CartId $id;

    public function __construct(
        private array $products,
    )
    {}

    public static function create(
        array $products
    )
    {
        return new self($products);
    }

    public function id(): CartId
    {
        return $this->id;
    }

    public function products(): array
    {
        return $this->products;
    }

    public function removeProduct(ProductId $productId)
    {
        if (($index = array_search($productId, $this->products)) !== false) {
            unset($this->products[$index]);
        }
    }

    public function addProduct(ProductId $productId)
    {
        $this->products[] = $productId;
    }
}