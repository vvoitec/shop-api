<?php

declare(strict_types=1);

namespace App\Common\Domain\Query;

use App\Common\Domain\Filtering\Criteria;
use App\Common\Domain\Query\Response;

interface Searcher
{
    public function searchAndCount(Criteria $criteria): Response;
}