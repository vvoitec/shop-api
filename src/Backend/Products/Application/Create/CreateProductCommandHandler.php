<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Create;

use App\Backend\Products\Domain\Product;
use App\Backend\Products\Domain\ProductPrice;
use App\Backend\Products\Domain\ProductRepository;
use App\Backend\Products\Domain\ProductTitle;
use App\Common\Domain\Bus\Command\CommandHandler;

class CreateProductCommandHandler implements CommandHandler
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function handle(CreateProductCommand $createProductCommand)
    {
        $title = new ProductTitle($createProductCommand->title());
        $price = new ProductPrice($createProductCommand->price());

        $this->productRepository->save(new Product($price, $title));
    }
}