<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Remove;

use App\Backend\Products\Domain\ProductRepository;
use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandHandler;

class RemoveProductCommandHandler implements CommandHandler
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {}

    public function handle(Command $command): void
    {
        $this->productRepository->removeById($command->id());
    }
}