<?php

namespace Hexa\PasswordResets\Application\Create;   

use Hexa\PasswordResets\Application\PasswordResetResponse;
use Hexa\PasswordResets\Domain\{ PasswordReset, PasswordResetNotExist, PasswordResetRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class CreatePasswordResetQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(PasswordResetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreatePasswordResetQuery $query)
    {
        $password_reset = PasswordReset::create(
            $query->email(),
            $query->token()
        );

        $repository = $this->repository->save($password_reset);
        
        return new PasswordResetResponse(
            $repository->email(),
            $repository->token()
        );

       
    }
}
