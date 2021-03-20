<?php

declare(strict_types=1);

namespace App\Backend\Cart\Infrastructure\Persistence\Mapping;

use App\Backend\Products\Domain\ProductId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;

class ProductIds extends JsonType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue(array_map(function (ProductId $productId) {
            return $productId->value();
        }, $value), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $scalars = parent::convertToPHPValue($value, $platform);

        return array_map(function (string $value) {
            return new ProductId((int)$value);
        }, $scalars);
    }

    public function getName()
    {
        return 'product_ids';
    }
}