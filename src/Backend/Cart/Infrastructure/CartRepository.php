<?php

declare(strict_types=1);

namespace App\Backend\Cart\Infrastructure;

use App\Backend\Cart\Domain\Cart;
use App\Backend\Cart\Domain\CartRepository as CartRepositoryInterface;
use App\Common\Infrastructure\Persistence\DoctrineRepository;

class CartRepository extends DoctrineRepository implements CartRepositoryInterface
{
    public function save(Cart $cart): void
    {
        $this->persist($cart);
    }
}