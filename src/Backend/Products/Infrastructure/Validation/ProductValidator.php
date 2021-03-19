<?php

declare(strict_types=1);

namespace App\Backend\Products\Infrastructure\Validation;

use App\Backend\Products\Domain\ProductRepository;
use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Validator;

class ProductValidator implements Validator
{
    public function __construct(
        private ProductRepository $productRepository,
    )
    {}

    public function isValidUpdate(Command $command)
    {
        $this->validateTitleUniqueness($command->title());
    }

    public function isValidCreate(Command $command)
    {
        if(empty($command->title()) || empty($command->price())){
            throw new \Exception('Price and title must not be empty');
        }
        $this->validateTitleUniqueness($command->title());
    }

    public function isValidRemove(Command $command)
    {
         $idExists = $this->productRepository->exists($command->id(), 'id');
         if (!$idExists) {
             throw new \Exception('Product with id: ' . $command->id() . ' doesn\'t exists');
         }
    }

    private function validateTitleUniqueness(string $title)
    {
        $titleExists = $this->productRepository->exists($title, 'title');
        if ($titleExists) {
            throw new \Exception('Product already exists');
        }
    }
}