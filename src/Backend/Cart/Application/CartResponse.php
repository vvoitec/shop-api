<?php

declare(strict_types=1);

namespace App\Backend\Cart\Application;

use App\Backend\Cart\Domain\Cart;
use App\Backend\Cart\Domain\TotalPrice;
use App\Backend\Products\Domain\ProductId;
use App\Common\Domain\Query\Response;

class CartResponse implements Response
{
    public function __construct(
        private Cart $cart,
        private TotalPrice $totalPrice,
    )
    {}

    public function jsonSerialize()
    {
        return [
            'data' => [
                'id' => $this->cart->id()->value(),
                'products' => array_map(fn(ProductId $productId) => '/product/'. $productId->value(), $this->cart->products()),
                'totalPrice' => $this->totalPrice->value(),
            ]
        ];
    }
}