<?php

declare(strict_types=1);

namespace App\Backend\Cart\Application\Application\Create;

use App\Backend\Cart\Domain\Cart;
use App\Backend\Cart\Domain\CartRepository;
use App\Backend\Products\Domain\ProductId;
use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandHandler;

class CreateCartCommandHandler implements CommandHandler
{
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function handle(Command $command): void
    {
        $cart = Cart::create(
            array_map(fn($id) => new ProductId($id), $command->products())
        );
        $this->cartRepository->save($cart);
    }
}