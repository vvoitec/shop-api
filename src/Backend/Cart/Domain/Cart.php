<?php

declare(strict_types=1);

namespace App\Backend\Cart\Domain;

use App\Common\Domain\AggregateRoot;
use App\Backend\Products\Domain\ProductId;

class Cart extends AggregateRoot
{
    private CartId $id;
    private array $products;

    public function __construct(ProductId ...$products)
    {
        if (count($products) > 3) throw new TooManyProductsException('Too many products in cart');
        $this->products = $products;
    }

    public static function create(
        ProductId ...$products
    )
    {
        return new self(...$products);
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
        if (count($this->products) > 3) throw new TooManyProductsException('Too many products in cart');
        $this->products[] = $productId;
    }
}