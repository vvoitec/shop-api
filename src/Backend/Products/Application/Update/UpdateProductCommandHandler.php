<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Update;

use App\Backend\Products\Domain\ProductPrice;
use App\Backend\Products\Domain\ProductRepository;
use App\Backend\Products\Domain\ProductTitle;
use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandHandler;


class UpdateProductCommandHandler implements CommandHandler
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function handle(Command $command): void
    {
        $product = $this->productRepository->searchById($command->id());
        if ($command->title()) {
            $product->rename(
                new ProductTitle($command->title())
            );
        }
        if ($command->price()) {
            $product->updatePrice(
                new ProductPrice($command->price())
            );
        }

        $this->productRepository->save($product);
    }

}