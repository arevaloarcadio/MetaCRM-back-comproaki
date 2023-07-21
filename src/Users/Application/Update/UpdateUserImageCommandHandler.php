<?php

namespace Hexa\Users\Application\Update;

use Hexa\Users\Domain\UserFinder;
use Hexa\Users\Domain\UserRepository;
use Hexa\Shared\Domain\Bus\Command\CommandHandler;

final class UpdateUserImageCommandHandler implements CommandHandler
{
    private $finder;
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        $this->finder = new UserFinder($repository);
    }

    public function __invoke(UpdateUserImageCommand $command): void
    {
        $user = $this->finder->__invoke($command->userId());

        $user->updateImage($command->image());
    
        $this->repository->updateImage($user);
    }
}
