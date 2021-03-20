<?php

declare(strict_types=1);

namespace App\Backend\Products\Domain;

use App\Common\Domain\Filtering\Criteria;

interface ProductRepository
{
    public function save(Product $product): void;

    public function searchByCriteria(?Criteria $criteria): array;

    public function countByCriteria(?Criteria $criteria): int;
}