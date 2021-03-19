<?php

declare(strict_types=1);

namespace App\Backend\Products\Application;

use App\Common\Domain\Query\Response;

class ProductsResponse implements Response
{
    private array $products;
    private int $total;

    public function __construct(int $total, ProductResponse ...$products)
    {
        $this->products = $products;
        $this->total = $total;
    }

    public function jsonSerialize(): array
    {
        $collection = array_map(function ($product) {
            return [
                'id' => $product->id(),
                'title' => $product->title(),
                'price' => $product->price(),
            ];
        }, $this->products);

        return [
            'data' => $collection,
            'total' => $this->total
        ];
    }
}