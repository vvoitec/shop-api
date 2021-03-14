<?php

declare(strict_types=1);

namespace App\Backend\Products\Domain;

interface ProductRepository
{
    public function save(Product $product): void;
}