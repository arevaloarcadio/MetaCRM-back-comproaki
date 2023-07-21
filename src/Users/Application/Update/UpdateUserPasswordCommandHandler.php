<?php

namespace Hexa\Users\Application\Update;

use Hexa\Users\Domain\UserFinder;
use Hexa\Users\Domain\UserRepository;
use Hexa\Shared\Domain\Bus\Command\CommandHandler;

final class UpdateUserPasswordCommandHandler implements CommandHandler
{
    private $finder;
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = new UserFinder($repository);
    }

    public function __invoke(UpdateUserPasswordCommand $command): void
    {
        $user = $this->finder->__invoke($command->userId());

        $user->updatePassword($command->password());

        $this->repository->updatePassword($user);
    }
}
