<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Factory;

use App\Common\Domain\Query\Searcher;

abstract class ServiceFactory
{
    public function __construct(protected iterable $services)
    {}
}