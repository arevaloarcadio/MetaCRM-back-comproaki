<?php

namespace Hexa\Users\Application\Update;

use Hexa\Shared\Domain\Bus\Command\CommandHandler;
use Hexa\Users\Domain\{ User, UserRepository };

final class UpdateUserCommandHandler implements CommandHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UpdateUserCommand $command)
    {
        $user = User::update(
            $command->id(),
            $command->firstname(),
            $command->lastname(),
            $command->email()
        );


        $this->repository->update($user);
    }
}
