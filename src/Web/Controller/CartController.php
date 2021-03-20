<?php

declare(strict_types=1);

namespace App\Web\Controller;

use App\Backend\Cart\Application\AddProduct\AddProductsToCartCommand;
use App\Backend\Cart\Application\Create\CreateCartCommand;
use App\Backend\Cart\Application\RemoveProduct\RemoveProductsFromCartCommand;
use App\Common\Domain\Filtering\Criteria;
use App\Common\Domain\Query\Searcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    private function getSearcher(): Searcher
    {
        return $this->searcherFactory->build('Cart');
    }

    public function createCart(Request $request)
    {
        $body = json_decode($request->getContent(), true);

        $createCartCommand = new CreateCartCommand(
            $body['products']
        );

        $this->commandBus->dispatch($createCartCommand);

        return new Response(
            'Created',
            Response::HTTP_OK
        );
    }

    public function getCart(int $slug)
    {
        $response = $this->getSearcher()->searchOne(
            new Criteria(
                ['id.value' => $slug]
            ),
        );

        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }

    public function addProductsToCart(int $slug, Request $request)
    {
        $body = json_decode($request->getContent(), true);

        $this->commandBus->dispatch(
            new AddProductsToCartCommand($slug, $body['products'])
        );

        return new JsonResponse('Products added', Response::HTTP_CREATED);
    }

    public function removeProductsFromCart(int $slug, Request $request)
    {
        $body = json_decode($request->getContent(), true);

        $this->commandBus->dispatch(
            new RemoveProductsFromCartCommand($slug, $body['products'])
        );

        return new JsonResponse('Products removed', Response::HTTP_CREATED);
    }
}