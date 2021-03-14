<?php

declare(strict_types=1);

namespace App\Backend\Common\Domain;

abstract class IntegerValueObject
{
    public function __construct(
        protected int $value
    )
    {}

    public function value(): string
    {
        return $this->value;
    }
}