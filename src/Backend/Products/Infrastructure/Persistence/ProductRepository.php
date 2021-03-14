<?php

declare(strict_types=1);

namespace App\Backend\Products\Infrastructure\Persistence;

use App\Backend\Products\Domain\Product;
use App\Common\Infrastructure\Persistence\DoctrineRepository;
use App\Backend\Products\Domain\ProductRepository as ProductRepositoryInterface;

class ProductRepository extends DoctrineRepository implements ProductRepositoryInterface
{
    public function save(Product $product): void
    {
        $this->persist($product);
    }
}