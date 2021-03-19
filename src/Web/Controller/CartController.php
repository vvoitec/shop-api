<?php

declare(strict_types=1);

namespace App\Web\Controller;

use App\Backend\Cart\Application\Create\CreateCartCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
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
}