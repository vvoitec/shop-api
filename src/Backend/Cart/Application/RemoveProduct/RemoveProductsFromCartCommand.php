<?php

declare(strict_types=1);

namespace App\Backend\Cart\Application\RemoveProduct;

use App\Common\Domain\Bus\Command\Command;

class RemoveProductsFromCartCommand implements Command
{
    public function __construct(
        private int $cartId,
        private array $products
    )
    {}

    public function id(): int
    {
        return $this->cartId;
    }

    public function products(): array
    {
        return $this->products;
    }
}