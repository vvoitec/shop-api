<?php

declare(strict_types=1);

namespace App\Backend\Products\Application\Create;

use App\Backend\Products\Domain\Product;
use App\Backend\Products\Domain\ProductPrice;
use App\Backend\Products\Domain\ProductRepository;
use App\Backend\Products\Domain\ProductTitle;
use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandHandler;
use App\Common\Domain\Bus\Exceptions\InvalidCommandException;
use App\Common\Domain\Validator;

class CreateProductCommandHandler implements CommandHandler
{
    public function __construct(
        private ProductRepository $productRepository
    )
    {}

    public function handle(Command $command): void
    {
        $this->validate($command);

        $title = new ProductTitle($command->title());
        $price = new ProductPrice($command->price());

        $this->productRepository->save(Product::create($price, $title));
    }

    private function validate(Command $command): void
    {
        if(empty($command->title()) || empty($command->price())){
            throw new InvalidCommandException('Price and title must not be empty');
        }
        $titleExists = $this->productRepository->exists($command->title(), 'title');
        if ($titleExists) {
            throw new InvalidCommandException('Title already exists!');
        }
    }
}