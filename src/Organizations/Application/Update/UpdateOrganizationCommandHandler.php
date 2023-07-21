<?php

namespace Hexa\Organizations\Application\Update;

use Hexa\Shared\Domain\Bus\Command\CommandHandler;
use Hexa\Organizations\Domain\{ Organization, OrganizationRepository };

final class UpdateOrganizationCommandHandler implements CommandHandler
{
    private $repository;

    public function __construct(OrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateOrganizationCommand $command)
    {
        $task = Organization::update(
            $command->id(),
            $command->parent_id(),
            $command->above_id(),
            $command->user_id(),
            $command->level(),
            $command->unit_id()
        );

        $this->repository->update($task);
    }
}
