<?php

declare(strict_types=1);

namespace App\Web\Controller;

use App\Common\Domain\Bus\Command\CommandBus;

abstract class AbstractController
{
    public function __construct(
        protected CommandBus $bus
    )
    {
    }
}