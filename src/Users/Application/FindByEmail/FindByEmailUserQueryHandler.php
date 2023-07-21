<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\FindByEmail;

use Hexa\Users\Application\UserResponse;
use Hexa\Users\Domain\{ UserNotExist, UserRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class FindByEmailUserQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindByEmailUserQuery $query): UserResponse
    {
        $user = $this->repository->findByEmail($query->email());

        $this->ensureUserExists($query->email(), $user);

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

