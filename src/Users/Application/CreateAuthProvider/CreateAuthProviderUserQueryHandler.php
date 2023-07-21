<?php

namespace Hexa\Users\Application\CreateAuthProvider;

use Hexa\Users\Application\UserResponse;
use Hexa\Users\Domain\{ User, UserNotExist, UserRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class CreateAuthProviderUserQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateAuthProviderUserQuery $query)
    {
        $user = User::createAuthProvider(
            $query->firstname(),
            $query->lastname(),
            $query->email(),
            $query->auth_provider()
        );

        $repository = $this->repository->saveAuthProvider($user);
        
        return new UserResponse(
            $repository->id(),
            $repository->firstname(),
            $repository->lastname(),
            $repository->email(),
            $repository->image()
        );
    }
}
