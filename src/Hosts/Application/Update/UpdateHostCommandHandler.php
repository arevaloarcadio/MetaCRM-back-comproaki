<?php

namespace Hexa\Hosts\Application\Update;

use Hexa\Shared\Domain\Bus\Command\CommandHandler;
use Hexa\Hosts\Domain\{ Host, HostRepository };

final class UpdateHostCommandHandler implements CommandHandler
{
    private $repository;

    public function __construct(HostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateHostCommand $command)
    {
        $host = Host::update(
            $command->id(),
            $command->domain()
        );

        $this->repository->update($host);
    }
}
