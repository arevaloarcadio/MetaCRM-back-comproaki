<?php

namespace Hexa\Users\Application\Update;

use Hexa\Users\Domain\UserFinder;
use Hexa\Users\Domain\{ User, UserRepository };
use Hexa\Shared\Domain\Bus\Command\CommandHandler;

final class UpdateUserActiveCommandHandler implements CommandHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateUserActiveCommand $command): void
    {
        $user = User::updateActive(
            $command->userId(),
            $command->active()
        );

        $this->repository->updateActive($user);
    }
}
