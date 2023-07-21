<?php

namespace Hexa\Shared\Infrastructure\Bus\Command;

use Hexa\Shared\Domain\Container\Container;
use Hexa\Shared\Domain\Bus\Command\{ Command, CommandBus };

final class SimpleCommandBus implements CommandBus
{
    private const COMMAND_SUFFIX = 'Command';
    private const HANDLER_SUFFIX = 'CommandHandler';

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function execute(Command $command): void
    {
        $this->resolverHandler($command)->__invoke($command);
    }

    private function resolverHandler(Command $command)
    {
        return $this->container->make( $this->getHandlerClass($command) );
    }

    private function getHandlerClass(Command $command): string
    {
        return str_replace(
            self::COMMAND_SUFFIX,
            self::HANDLER_SUFFIX,
            get_class($command)
        );
    }
}
