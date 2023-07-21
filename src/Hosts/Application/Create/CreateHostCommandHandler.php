<?php

namespace Hexa\Hosts\Application\Create;

use Hexa\Shared\Domain\Bus\Command\CommandHandler;
use Hexa\Hosts\Domain\{ Host, HostRepository };

final class CreateHostCommandHandler implements CommandHandler
{
    private $repository;

    public function __construct(HostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateHostCommand $command)
    {
        $host = Host::create(
            $command->domain()
        );

        $this->repository->save($host);
    }
}
