<?php

declare(strict_types = 1);

namespace Hexa\PasswordResets\Application\Delete;

use Hexa\PasswordResets\Application\PasswordResetResponse;
use Hexa\PasswordResets\Domain\{ PasswordResetNotExist, PasswordResetRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class DeletePasswordResetQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(PasswordResetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeletePasswordResetQuery $query): void
    {
        $password_reset = $this->repository->findByEmail($query->email());

        $this->ensurePasswordResetExists($query->email(), $password_reset);

        $this->repository->delete($query->email());
    }

    private function ensurePasswordResetExists($email, $password_reset)
    {
        if ( null === $password_reset ) throw new PasswordResetNotExist($email);
    }
}

