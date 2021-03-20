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

class ProductController extends Controller
{
    private function getSearcher(): Searcher
    {
        return $this->searcherFactory->build('Product');
    }

    #[Route('/product', name: 'product.search', methods: ['get'])]
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

    #[Route('/product', name: 'product.create', methods: ['post'])]
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

    #[Route('/product/{id}', name: 'product.update', methods: ['put'])]
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

    #[Route('/product/{id}', name: 'product.delete', methods: ['delete'])]
    public function removeProduct(int $slug)
    {
        $removeProductCommand = new RemoveProductCommand($slug);
        $this->commandBus->dispatch($removeProductCommand);

        return new JsonResponse(
            'Removed',
            Response::HTTP_OK
        );
    }

    #[Route('/product/{id}', name: 'product.delete', methods: ['get'])]
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