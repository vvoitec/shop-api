<?php

declare(strict_types=1);

namespace App\Backend\Cart\Application\AddProduct;

use App\Backend\Cart\Domain\CartRepository;
use App\Backend\Products\Domain\ProductId;
use App\Backend\Products\Domain\ProductRepository;
use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandHandler;
use App\Common\Domain\Bus\Exceptions\InvalidCommandException;
use App\Common\Domain\Filtering\Criteria;

class AddProductsToCartCommandHandler implements CommandHandler
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository
    )
    {}

    public function handle(Command $command): void
    {
        $cart = $this->cartRepository->searchOneByCriteria(new Criteria(['id.value' => $command->id()]));
        foreach ($command->products() as $productId) {
            $this->validateProductId($productId);
            $cart->addProduct(new ProductId($productId));
        }
        $this->cartRepository->save($cart);
    }

    private function validateProductId($productId): void
    {
        $productExists = $this->productRepository->isExistingByCriteria(new Criteria(['id.value' => $productId]));
        if (!$productExists) throw new InvalidCommandException('Invalid product given');
    }
}