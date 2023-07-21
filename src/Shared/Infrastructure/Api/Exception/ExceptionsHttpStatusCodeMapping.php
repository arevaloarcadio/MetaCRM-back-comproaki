<?php

declare(strict_types = 1);

namespace Hexa\Shared\Infrastructure\Api\Exception;

use InvalidArgumentException;
use function Lambdish\Phunctional\get;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Hexa\Shared\Domain\Exception\ExceptionsCodeMapping;

final class ExceptionsHttpStatusCodeMapping implements ExceptionsCodeMapping
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    private $exceptions = [
        InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
        NotFoundHttpException::class    => Response::HTTP_NOT_FOUND,
    ];

    public function register($exceptionClass, $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function exists($exceptionClass): bool
    {
        return array_key_exists($exceptionClass, $this->exceptions);
    }

    public function getStatusCodeFor($exceptionClass)
    {
        return get($exceptionClass, $this->exceptions, self::DEFAULT_STATUS_CODE);
    }
}
