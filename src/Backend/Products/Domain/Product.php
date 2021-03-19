<?php

declare(strict_types=1);

namespace App\Backend\Products\Domain;

use App\Backend\Products\Domain\ProductId;
use App\Common\Domain\AggregateRoot;

class Product extends AggregateRoot
{
    private ProductId $id;

    public function __construct(
        private ProductPrice $price,
        private ProductTitle $title
    )
    {
    }

    public static function create(
        ProductPrice $price,
        ProductTitle $title
    )
    {
        return new self($price, $title);
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function title(): ProductTitle
    {
        return $this->title;
    }

    public function rename(ProductTitle $newTitle)
    {
        $this->title = $newTitle;
    }

    public function updatePrice(ProductPrice $newPrice)
    {
        $this->price = $newPrice;
    }
}