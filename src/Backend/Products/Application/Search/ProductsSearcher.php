<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Search;

use App\Backend\Products\Application\ProductResponse;
use App\Backend\Products\Application\ProductsResponse;
use App\Backend\Products\Domain\ProductRepository;
use App\Common\Domain\Filtering\Criteria;
use App\Common\Domain\Query\Searcher;
use Doctrine\Common\Collections\Expr\Expression;

class ProductsSearcher implements Searcher
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {}

    public function searchOne(Criteria $criteria): ProductResponse
    {
        $product = $this->productRepository->searchOneByCriteria($criteria);
        return new ProductResponse($product);
    }

    public function searchAndCount(Criteria $criteria): ProductsResponse
    {
        $products = $this->productRepository->searchByCriteria($criteria);
        $total = $this->productRepository->countByCriteria($criteria);

        return new ProductsResponse($total,
            ...array_map(function ($product) {
                return new ProductResponse($product);
            }, $products));
    }
}