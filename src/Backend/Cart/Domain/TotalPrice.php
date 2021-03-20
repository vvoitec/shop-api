<?php

declare(strict_types=1);

namespace App\Backend\Cart\Domain;

use App\Backend\Common\Domain\StringValueObject;
use App\Backend\Products\Domain\ProductPrice;

class TotalPrice extends StringValueObject
{
    public function __construct(ProductPrice ...$prices)
    {
        $this->value = (string)array_reduce(
            $prices,
            function($total, $prices) {
                $total += (float)$prices->value();
                return $total;
            });
    }
}