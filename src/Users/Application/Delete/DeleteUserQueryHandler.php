<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\Delete;

use Hexa\Users\Application\UserResponse;
use Hexa\Users\Domain\{ UserNotExist, UserRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class DeleteUserQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteUserQuery $query): void
    {
        $user = $this->repository->find($query->id());

        $this->ensureUserExists($query->id(), $user);

        $this->repository->delete($query->id());
    }

    private function ensureUserExists($id, $user)
    {
        if ( null === $user ) throw new UserNotExist($id);
    }
}

