<?php

declare(strict_types=1);

namespace App\Backend\Products\Application;

use App\Backend\Products\Domain\Product;
use App\Common\Domain\Query\Response;

class ProductResponse implements Response
{
    public function __construct(private Product $product)
    {
    }

    public function id(): int
    {
        return $this->product->id()->value();
    }

    public function price(): string
    {
        return $this->product->price()->value();
    }

    public function title(): string
    {
        return $this->product->title()->value();
    }

    public function jsonSerialize()
    {
        return [
            'data' => [
                'id' => $this->id(),
                'title' => $this->title(),
                'price' => $this->price()
            ]
        ];
    }
}