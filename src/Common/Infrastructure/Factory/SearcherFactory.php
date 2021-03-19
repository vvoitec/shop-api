<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Factory;

use App\Backend\Products\Application\Search\ProductsSearcher;
use App\Common\Domain\Query\Searcher;
use App\Common\Infrastructure\Factory\Interfaces\SearcherFactory as SearcherFactoryInterface;
use App\Web\Controller\ProductController;

class SearcherFactory extends ServiceFactory implements SearcherFactoryInterface
{
    public function build(string $type): Searcher
    {
        foreach($this->services as $service) {
            if (str_contains(get_class($service), $type)) {
                return $service;
            }
        }
    }
}