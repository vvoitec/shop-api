<?php

declare(strict_types=1);

namespace App\Backend\Cart\Application\Search;

use App\Backend\Cart\Domain\Cart;
use App\Backend\Cart\Domain\CartRepository;
use App\Backend\Cart\Domain\TotalPrice;
use App\Backend\Products\Domain\ProductRepository;
use App\Common\Domain\Filtering\Criteria;

class TotalPriceCounter
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {}

    public function count(Cart $cart): TotalPrice
    {
        $products = $this->productRepository->searchByCriteria(new Criteria(['id.value' => $cart->products()]));
        return new TotalPrice(...array_map(fn($product) => $product->price(), $products));
    }
}