<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Validation;

use App\Backend\Cart\Domain\TooManyProductsException;
use App\Common\Domain\Bus\Exceptions\InvalidCommandException;
use App\Common\Infrastructure\Persistence\InvalidIdentityException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApplicationExceptionListener
{
    private array $exceptions = [
        InvalidCommandException::class => Response::HTTP_BAD_REQUEST,
        InvalidIdentityException::class => Response::HTTP_BAD_REQUEST,
        TooManyProductsException::class => Response::HTTP_BAD_REQUEST,
    ];

    public function onException(ExceptionEvent $event) {
        $exception = $event->getThrowable();

        try {
            $event->setResponse(
                new JsonResponse(
                    $exception->getMessage(),
                    $this->exceptions[get_class($exception)]
                )
            );
        } finally {
            return;
        }
    }
}