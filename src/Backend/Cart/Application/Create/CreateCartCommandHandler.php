<?php

declare(strict_types=1);

namespace App\Backend\Cart\Application\Create;

use App\Backend\Cart\Domain\Cart;
use App\Backend\Cart\Domain\CartRepository;
use App\Backend\Products\Domain\ProductId;
use App\Backend\Products\Domain\ProductRepository;
use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandHandler;
use App\Common\Domain\Bus\Exceptions\InvalidCommandException;
use App\Common\Domain\Filtering\Criteria;

class CreateCartCommandHandler implements CommandHandler
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
    )
    {}

    public function handle(Command $command): void
    {
        $this->validateProductIds($command->products());
        $cart = Cart::create(
            ...array_map(fn($id) => new ProductId($id), $command->products())
        );
        $this->cartRepository->save($cart);
    }

    private function validateProductIds($productIds): void
    {
        $productExists = $this->productRepository->isExistingByCriteria(new Criteria(['id.value' => $productIds]));
        if (!$productExists) throw new InvalidCommandException('Invalid product given');
    }
}