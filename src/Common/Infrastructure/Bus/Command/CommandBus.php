<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Command;

use App\Backend\Products\Application\Create\CreateProductCommandHandler;
use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;

class CommandBus implements \App\Common\Domain\Bus\Command\CommandBus
{
    private MessageBusSupportingMiddleware $bus;
    private CreateProductCommandHandler $createProductCommandHandler;

    public function __construct(CreateProductCommandHandler $createProductCommandHandler)
    {
        $this->createProductCommandHandler = $createProductCommandHandler;

        $commandHandlersByCommandName = [
            'App\Backend\Products\Application\Create\CreateProductCommand' => array('create_product_command_handler', 'handle')
        ];

        $serviceLocator = function ($serviceId) {
            if ('create_product_command_handler' === $serviceId) {
//                return new CreateProductCommandHandler();
                return $this->createProductCommandHandler;
            }
        };

        $commandHandlerMap = new CallableMap(
            $commandHandlersByCommandName,
            new ServiceLocatorAwareCallableResolver($serviceLocator)
        );


        $this->bus = new MessageBusSupportingMiddleware();
        $this->bus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());
        $this->bus->appendMiddleware(new DelegatesToMessageHandlerMiddleware(
            new NameBasedMessageHandlerResolver(
                new ClassBasedNameResolver(),
                $commandHandlerMap
            )
        ));
    }

    public function dispatch(Command $command): void
    {
        $this->bus->handle($command);
    }
}