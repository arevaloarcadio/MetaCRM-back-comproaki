<?php

declare(strict_types=1);

namespace Hexa\Users\Domain;

final class UserFinder
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $id): User
    {
        $user = $this->repository->find($id);

        if (null === $user) {
            throw new UserNotExist($id);
        }

        return $user;
    }
}
