<?php

declare(strict_types=1);

namespace App\Common\Domain\Filtering;

class Criteria
{
    private ?array $filters;
    private int $limit;
    private int $offset;

    // TODO: add ordering
    public function __construct(?array $filters, ?string $offset, ?string $limit)
    {
        $this->filters = $filters;
        $this->limit = $limit ? (int)$limit : 3;
        $this->offset = (int)$offset;
    }

    public function filters()
    {
        return $this->filters;
    }

    public function limit()
    {
        return $this->limit;
    }

    public function offset()
    {
        return $this->offset;
    }
}