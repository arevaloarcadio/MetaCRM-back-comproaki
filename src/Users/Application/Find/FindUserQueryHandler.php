<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\Find;

use Hexa\Users\Application\UserResponse;
use Hexa\Users\Domain\{ UserNotExist, UserRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class FindUserQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindUserQuery $query): UserResponse
    {
        $user = $this->repository->find($query->id());

        $this->ensureUserExists($query->id(), $user);

        return new UserResponse(
            $user->id(),
            $user->firstname(),
            $user->lastname(),
            $user->email(),
            $user->image(),
            null,
            $user->active()
        );
    }

    private function ensureUserExists($id, $user)
    {
        if ( null === $user ) throw new UserNotExist($id);
    }
}

