<?php

declare(strict_types=1);

namespace App\Backend\Products\Domain;

use App\Common\Domain\Filtering\Criteria;
use Doctrine\Common\Collections\ArrayCollection;

interface ProductRepository
{
    public function save(Product $product): void;

    public function search(?Criteria $criteria): array;

    public function count(?Criteria $criteria): int;
}