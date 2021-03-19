<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Remove;

use App\Common\Domain\Bus\Command\Command;

class RemoveProductCommand implements Command
{
    public function __construct(
        private int $id,
    )
    {}

    public function id(): int
    {
        return $this->id;
    }
}