<?php

namespace Hexa\Shared\Infrastructure\Bus\Query;

use Hexa\Shared\Domain\Container\Container;
use Hexa\Shared\Domain\Bus\Query\{ Query, QueryBus,Response };


final class SimpleQueryBus implements QueryBus
{
    private const COMMAND_SUFFIX = 'Query';
    private const HANDLER_SUFFIX = 'QueryHandler';

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function ask(Query $query) : ?Response
    {
        return $this->resolverHandler($query)->__invoke($query);
    }

    private function resolverHandler(Query $query)
    {
        return $this->container->make( $this->getHandlerClass($query) );
    }

    private function getHandlerClass(Query $query): string
    {
        return str_replace(
            self::COMMAND_SUFFIX,
            self::HANDLER_SUFFIX,
            get_class($query)
        );
    }
}
