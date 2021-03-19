<?php

declare(strict_types=1);

namespace App\Backend\Products\Infrastructure\Persistence;

use App\Backend\Products\Domain\Product;
use App\Common\Domain\Filtering\Criteria;
use App\Common\Infrastructure\Persistence\DoctrineCriteriaAdapter;
use App\Common\Infrastructure\Persistence\DoctrineRepository;
use App\Backend\Products\Domain\ProductRepository as ProductRepositoryInterface;

class ProductRepository extends DoctrineRepository implements ProductRepositoryInterface
{
    public function save(Product $product): void
    {
        $this->persist($product);
    }

    public function removeById(int $id): void
    {
        $product = $this->searchById($id);
        $this->remove($product);
    }

    public function search(?Criteria $criteria): array
    {
        return parent::search($criteria);
    }

    public function count(?Criteria $criteria): int
    {
        return parent::count($criteria);
    }

    public function exists(string | int  $field, string $column): bool
    {
        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->select('p')
                    ->from(Product::class, 'p')
                    ->where('p.'.$column.'.value = :field')
                    ->setParameter(':field', $field)
                    ->setMaxResults(1)
                    ->getQuery();

        return count($query->getResult()) > 0;
    }
}