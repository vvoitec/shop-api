<?php

declare(strict_types=1);

namespace App\Backend\Cart\Application\Application\Create;

use App\Common\Domain\Bus\Command\Command;

class CreateCartCommand implements Command
{
    public function __construct(
        private array $products
    )
    {}

    public function products(): array
    {
        return $this->products;
    }
}