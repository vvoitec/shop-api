<?php

declare(strict_types=1);

namespace App\Web\Controller;

use App\Backend\Cart\Application\Search\CartSearcher;
use App\Backend\Products\Application\Search\ProductsSearcher;
use App\Common\Domain\Bus\Command\CommandBus;
use App\Common\Infrastructure\Factory\Interfaces\SearcherFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class Controller extends AbstractController
{
    public function __construct(
        protected CommandBus $commandBus,
        protected SearcherFactory $searcherFactory,
    )
    {
    }
}