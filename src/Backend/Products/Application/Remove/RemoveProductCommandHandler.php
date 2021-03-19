<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Remove;

use App\Backend\Products\Domain\ProductRepository;
use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandHandler;
use App\Common\Domain\Bus\Exceptions\InvalidCommandException;

class RemoveProductCommandHandler implements CommandHandler
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {}

    public function handle(Command $command): void
    {
        $this->validate($command);

        $this->productRepository->removeById($command->id());
    }

    private function validate(Command $command): void
    {
        $productExists = $this->productRepository->exists($command->id(), 'id');
        if (!$productExists) {
            throw new InvalidCommandException('Product with given id doesn\'t exist');
        }
    }
}