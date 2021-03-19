<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Update;

use App\Common\Domain\Bus\Command\Command;

class UpdateProductCommand implements Command
{
    public function __construct(
        private int $id,
        private ?string $title,
        private ?string $price,
    )
    {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function price(): ?string
    {
        return $this->price;
    }
}