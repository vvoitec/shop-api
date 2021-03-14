<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Create;

use App\Common\Domain\Bus\Command\CommandHandler;

class CreateProductCommandHandler implements CommandHandler
{
    public function handle(CreateProductCommand $createProductCommand)
    {
        dump("Hello from handler!");
    }
}