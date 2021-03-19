<?php

declare(strict_types=1);

namespace App\Common\Domain\Query;

interface Response extends \JsonSerializable
{
    public function jsonSerialize();
}