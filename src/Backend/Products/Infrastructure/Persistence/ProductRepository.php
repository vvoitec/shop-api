<?php

declare(strict_types=1);

namespace App\Backend\Products\Infrastructure\Persistence;

use App\Backend\Products\Domain\Product;
use App\Backend\Products\Domain\ProductId;
use App\Common\Domain\Filtering\Criteria;
use App\Common\Infrastructure\Persistence\DoctrineRepository;
use App\Backend\Products\Domain\ProductRepository as ProductRepositoryInterface;

class ProductRepository extends DoctrineRepository implements ProductRepositoryInterface
{
    public function save(Product $product): void
    {
        $this->persist($product);
    }

    public function removeById(int | string $id): void
    {
        $product = $this->searchOneByCriteria(new Criteria(['id.value' => $id]));
        $this->remove($product);
    }

    public function searchOneByCriteria(?Criteria $criteria): Product
    {
        return $this->repository(Product::class)->withCriteria($criteria)->searchOne();
    }

    public function searchByCriteria(?Criteria $criteria): array
    {
        return $this->repository(Product::class)->withCriteria($criteria)->search();
    }

    public function countByCriteria(?Criteria $criteria): int
    {
        return $this->repository(Product::class)->withCriteria($criteria)->count();
    }

    public function isExistingByCriteria(?Criteria $criteria): bool
    {
        return $this->countByCriteria($criteria) > 0;
    }
}