<?php

namespace Hexa\Users\Application\Create;



use Hexa\Users\Application\UserResponse;
use Hexa\Users\Domain\{ User, UserNotExist, UserRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class CreateUserQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateUserQuery $query)
    {
        $user = User::create(
            $query->firstname(),
            $query->lastname(),
            $query->email(),
            $query->password()
        );

        $repository = $this->repository->save($user);
        
        return new UserResponse(
            $repository->id(),
            $repository->firstname(),
            $repository->lastname(),
            $repository->email(),
            $repository->image()
        );

       
    }
}
