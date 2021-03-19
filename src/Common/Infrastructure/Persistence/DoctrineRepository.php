<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Persistence;

use App\Backend\Products\Domain\Product;
use App\Common\Domain\AggregateRoot;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Common\Domain\Filtering\Criteria;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;

class DoctrineRepository
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected CriteriaAdapter $criteriaAdapter,
    )
    {}

    protected function persist(AggregateRoot $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush($entity);
    }

    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush($entity);
    }

    protected function repository(string $entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }

    public function search(Criteria $criteria): array
    {
        return $this->repository(Product::class)->matching($this->convertCriteria($criteria))->toArray();
    }

    public function count(?Criteria $criteria): int
    {
        return $this->repository(Product::class)->matching($this->convertCriteria($criteria))->count();
    }

    private function convertCriteria(Criteria $criteria): DoctrineCriteria
    {
        return $this->criteriaAdapter->convert($criteria);
    }
}