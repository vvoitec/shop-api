<?php

declare(strict_types=1);

namespace App\Web\Controller;

use App\Backend\Products\Application\Create\CreateProductCommand;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'create_product')]
    public function createProduct()
    {
        $this->bus->dispatch(new CreateProductCommand(
            '1',
            'test',
            '12,99'
        ));

        return new Response(
            'Hello World!',
            Response::HTTP_OK
        );
    }
}