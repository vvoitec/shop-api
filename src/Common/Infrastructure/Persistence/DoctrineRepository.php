<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Persistence;

use App\Backend\Cart\Domain\Cart;
use App\Backend\Products\Domain\Product;
use App\Common\Domain\AggregateRoot;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Common\Domain\Filtering\Criteria;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;

class DoctrineRepository
{
    private EntityRepository $entityRepository;
    private ?DoctrineCriteria $criteria = null;

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

    protected function repository(string $entityClass): DoctrineRepository
    {
        $this->entityRepository = $this->entityManager->getRepository($entityClass);
        return $this;
    }

    protected function withCriteria(Criteria $criteria): DoctrineRepository
    {
        $this->criteria = $this->criteriaAdapter->convert($criteria);
        return $this;
    }

    protected function search()
    {
        return $this->entityRepository->matching($this->criteria)->toArray();
    }

    protected function searchOne()
    {
        $entity = $this->entityRepository->matching($this->criteria)->first();
        if (!$entity) throw new InvalidIdentityException('Invalid identity');

        return $entity;
    }

    public function count(): int
    {
        return $this->entityRepository->matching($this->criteria)->count();
    }
}