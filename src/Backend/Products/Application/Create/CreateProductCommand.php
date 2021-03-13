<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Create;

use App\Common\Domain\Bus\Command\Command;

class CreateProductCommand implements Command
{
    public function __construct(
        private string $id,
        private string $title,
        private string $price,
    )
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function price(): string
    {
        return $this->price;
    }
}