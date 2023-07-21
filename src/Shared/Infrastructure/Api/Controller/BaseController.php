<?php

declare(strict_types = 1);

namespace Hexa\Shared\Infrastructure\Api\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use function Lambdish\Phunctional\each;
use Hexa\Shared\Domain\Exception\ExceptionsCodeMapping;
use Hexa\Shared\Domain\Bus\Command\{ Command, CommandBus };
use Hexa\Shared\Domain\Bus\Query\{ Query, QueryBus, Response };

abstract class BaseController
{
    use ValidatesRequests;

    private $queryBus;
    private $commandBus;
    private $exceptionHandler;

    public function __construct(
        QueryBus $queryBus,
        CommandBus $commandBus,
        ExceptionsCodeMapping $exceptionHandler
    ) {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->exceptionHandler = $exceptionHandler;

        each($this->registerException(), $this->exceptions());
    }


    abstract protected function exceptions(): array;


    protected function execute(Command $command)
    {
        $this->commandBus->execute($command);
    }

    protected function ask(Query $query) : ?Response
    {
        return $this->queryBus->ask($query);
    }

    private function registerException(): callable
    {
        return function ($httpCode, $exception): void {
            $this->exceptionHandler->register($exception, $httpCode);
        };
    }
}
