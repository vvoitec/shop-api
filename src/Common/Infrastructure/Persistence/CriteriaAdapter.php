<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Persistence;

use App\Common\Domain\Filtering\Criteria;

interface CriteriaAdapter
{
    public function convert(Criteria $criteria);
}