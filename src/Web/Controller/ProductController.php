<?php

declare(strict_types=1);

namespace App\Web\Controller;

use App\Backend\Products\Application\Create\CreateProductCommand;
use App\Backend\Products\Application\Remove\RemoveProductCommand;
use App\Backend\Products\Application\Update\UpdateProductCommand;
use App\Common\Domain\Filtering\Criteria;
use App\Common\Domain\Query\Searcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    private function getSearcher(): Searcher
    {
        return $this->searcherFactory->build('Product');
    }

    /**
     * @OA\Get(
     *     path="/product",
     *     tags={"product"},
     *     description="Collection operation for searching products",
     *     operationId="searchProducts",
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          @OA\Schema(
     *              type="int",
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="title",
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          @OA\Schema(
     *              type="int",
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="offset",
     *          in="query",
     *          @OA\Schema(
     *              type="int",
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="success",
     *      ),
     * )
     */
    public function searchProducts(Request $request)
    {
        $id = $request->query->get('id');
        $title = $request->query->get('title');
        $limit = $request->query->get('limit');
        $offset = $request->query->get('offset');

        $response = $this->getSearcher()->searchAndCount(
            new Criteria(
                ['id.value' => $id, 'title.value' => $title],
                $offset,
                $limit,
            ),
        );

        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }

    /**
     * @OA\Post(
     *     path="/product",
     *     tags={"product"},
     *     operationId="createProduct",
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation exception",
     *     ),
     *     requestBody={"$ref": "#/components/requestBodies/Product"}
     * )
     */
    public function createProduct(Request $request)
    {
        $body = json_decode($request->getContent(), true);

        $productCommand = new CreateProductCommand(
            $body['title'] ?? null,
            $body['price'] ?? null,
        );

        $this->commandBus->dispatch($productCommand);

        return new JsonResponse(
            'Created',
            Response::HTTP_CREATED
        );
    }

    /**
     * @OA\Put(
     *     path="/product/{id}",
     *     tags={"product"},
     *     operationId="updateProduct",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          @OA\Schema(
     *              type="int",
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Updated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation exception",
     *     ),
     *     requestBody={"$ref": "#/components/requestBodies/Product"}
     * )
     */
    public function updateProduct(int $slug, Request $request)
    {
        $body = json_decode($request->getContent(), true);

        $updateProductCommand = new UpdateProductCommand(
            $slug,
            $body['title'] ?? null,
            $body['price'] ?? null,
        );

        $this->commandBus->dispatch($updateProductCommand);

        return new JsonResponse(
            'Updated',
            Response::HTTP_CREATED
        );
    }

    /**
     * @OA\Delete(
     *     path="/product/{id}",
     *     tags={"product"},
     *     operationId="removeProduct",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          @OA\Schema(
     *              type="int",
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Removed",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation exception",
     *     ),
     * )
     */
    public function removeProduct(int $slug)
    {
        $removeProductCommand = new RemoveProductCommand($slug);
        $this->commandBus->dispatch($removeProductCommand);

        return new JsonResponse(
            'Removed',
            Response::HTTP_ACCEPTED
        );
    }


    public function getProduct(int $slug)
    {
        $response = $this->getSearcher()->searchOne(
            new Criteria(
                ['id.value' => $slug],
            ),
        );

        return new JsonResponse(
            $response,
            Response::HTTP_OK
        );
    }
}