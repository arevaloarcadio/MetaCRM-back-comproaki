<?php

declare(strict_types = 1);

namespace Hexa\PasswordResets\Application\Find;

use Hexa\PasswordResets\Application\PasswordResetResponse;
use Hexa\PasswordResets\Domain\{ PasswordResetNotExist, PasswordResetRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class FindPasswordResetQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(PasswordResetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindPasswordResetQuery $query): PasswordResetResponse
    {
        $password_reset = $this->repository->find($query->token());

        $this->ensurePasswordResetExists($query->token(), $password_reset);

        return new PasswordResetResponse(
            $password_reset->email(),
            $password_reset->token()
        );
    }

    private function ensurePasswordResetExists($token, $password_reset)
    {
        if ( null === $password_reset ) throw new PasswordResetNotExist($token);
    }
}

