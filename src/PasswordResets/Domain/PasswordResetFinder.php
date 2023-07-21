<?php

declare(strict_types=1);

namespace Hexa\PasswordResets\Domain;

final class PasswordResetFinder
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
            throw new PasswordResetNotExist($id);
        }

        return $user;
    }
}
