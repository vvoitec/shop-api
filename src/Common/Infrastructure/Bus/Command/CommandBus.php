<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Bus\Command;

use App\Backend\Cart\Application\AddProduct\AddProductToCartCommand;
use App\Backend\Cart\Application\AddProduct\AddProductToCartCommandHandler;
use App\Backend\Cart\Application\Create\CreateCartCommand;
use App\Backend\Cart\Application\Create\CreateCartCommandHandler;
use App\Backend\Products\Application\Create\CreateProductCommand;
use App\Backend\Products\Application\Create\CreateProductCommandHandler;
use App\Backend\Products\Application\Remove\RemoveProductCommand;
use App\Backend\Products\Application\Remove\RemoveProductCommandHandler;
use App\Backend\Products\Application\Update\UpdateProductCommand;
use App\Backend\Products\Application\Update\UpdateProductCommandHandler;
use App\Common\Domain\Bus\Command\Command;
use Psr\Container\ContainerInterface;
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
    private ContainerInterface $serviceLocator;
    private CallableMap $commandHandlerMap;
    private array $subscribedEvents = [
            CreateProductCommand::class => array(CreateProductCommandHandler::class, 'handle'),
            RemoveProductCommand::class => array(RemoveProductCommandHandler::class, 'handle'),
            UpdateProductCommand::class => array(UpdateProductCommandHandler::class, 'handle'),
            CreateCartCommand::class => array(CreateCartCommandHandler::class, 'handle'),
            AddProductToCartCommand::class => array(AddProductToCartCommandHandler::class, 'handle')
        ];

    public function __construct(ContainerInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->initialize();
    }

    private function initialize()
    {
        $this->createMapHandlers();
        $this->bus = new MessageBusSupportingMiddleware();
        $this->bus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());
        $this->bus->appendMiddleware(new DelegatesToMessageHandlerMiddleware(
            new NameBasedMessageHandlerResolver(
                new ClassBasedNameResolver(),
                $this->commandHandlerMap
            )
        ));
    }

    private function createMapHandlers()
    {
        $this->commandHandlerMap = new CallableMap(
            $this->subscribedEvents,
            new ServiceLocatorAwareCallableResolver(fn($id) => $this->serviceLocator->get($id))
        );
    }

    public function dispatch(Command $command): void
    {
        $this->bus->handle($command);
    }
}