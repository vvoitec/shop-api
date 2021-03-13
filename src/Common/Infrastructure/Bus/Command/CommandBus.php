<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Command;

use App\Common\Domain\Bus\Command\Command;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;

class CommandBus implements \App\Common\Domain\Bus\Command\CommandBus
{
    private MessageBusSupportingMiddleware $bus;

    public function __construct()
    {
        $commandHandlerMap = new CallableMap(array(
            'App\Backend\Products\Application\Create\CreateProductCommandHandler' => array('create_product_command_handler', 'handle'),
        ), new ServiceLocatorAwareCallableResolver(function ($serviceId) {
            if ('create_product_command_handler' === $serviceId) {
                return new App\Backend\Products\Application\Create\CreateProductCommandHandler();
            }
        }));

        $this->bus = new MessageBusSupportingMiddleware();
        $this->bus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());
    }

    public function dispatch(Command $command): void
    {
        $this->bus->handle($command);
    }
}