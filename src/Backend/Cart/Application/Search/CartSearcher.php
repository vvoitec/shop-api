<?php

declare(strict_types=1);

namespace App\Backend\Cart\Application\Search;

use App\Backend\Cart\Application\CartResponse;
use App\Backend\Cart\Domain\Cart;
use App\Backend\Cart\Domain\CartRepository;
use App\Backend\Products\Domain\ProductRepository;
use App\Common\Domain\Filtering\Criteria;
use App\Common\Domain\Query\Response;
use App\Common\Domain\Query\Searcher;

class CartSearcher implements Searcher
{
    public function __construct(
        private CartRepository $cartRepository,
        private TotalPriceCounter $priceCounter,
    )
    {}

    public function searchOne(Criteria $criteria): Response
    {
        $cart = $this->cartRepository->searchOneByCriteria($criteria);
        return new CartResponse($cart, $this->priceCounter->count($cart));
    }
}