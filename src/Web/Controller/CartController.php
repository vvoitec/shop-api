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
use OpenApi\Annotations as OA;

class CartController extends Controller
{
    private function getSearcher(): Searcher
    {
        return $this->searcherFactory->build('Cart');
    }

    /**
     * @OA\Post(
     *     path="/cart",
     *     tags={"cart"},
     *     operationId="createCart",
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation exception",
     *     ),
     *     requestBody={"$ref": "#/components/requestBodies/Cart"}
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/cart/{id}",
     *     tags={"cart"},
     *     operationId="getCart",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          @OA\Schema(
     *              type="int",
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *     ),
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/cart/{id}/add",
     *     tags={"cart"},
     *     operationId="addProductsToCart",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          @OA\Schema(
     *              type="int",
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Added",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation exception",
     *     ),
     *     requestBody={"$ref": "#/components/requestBodies/Cart"}
     * )
     */
    public function addProductsToCart(int $slug, Request $request)
    {
        $body = json_decode($request->getContent(), true);

        $this->commandBus->dispatch(
            new AddProductsToCartCommand($slug, $body['products'])
        );

        return new JsonResponse('Products added', Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/cart/{id}/remove",
     *     tags={"cart"},
     *     operationId="removeProductsFromCart",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          @OA\Schema(
     *              type="int",
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Added",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation exception",
     *     ),
     *     requestBody={"$ref": "#/components/requestBodies/Cart"}
     * )
     */
    public function removeProductsFromCart(int $slug, Request $request)
    {
        $body = json_decode($request->getContent(), true);

        $this->commandBus->dispatch(
            new RemoveProductsFromCartCommand($slug, $body['products'])
        );

        return new JsonResponse('Products removed', Response::HTTP_CREATED);
    }
}