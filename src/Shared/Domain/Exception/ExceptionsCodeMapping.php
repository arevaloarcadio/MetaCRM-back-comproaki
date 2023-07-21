<?php

namespace Hexa\Shared\Domain\Exception;

interface ExceptionsCodeMapping
{
    public function register($exceptionClass, $statusCode): void;

    public function exists($exceptionClass): bool;

    public function getStatusCodeFor($exceptionClass);
}
