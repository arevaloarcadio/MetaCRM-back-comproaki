<?php


declare(strict_types = 1);

namespace Hexa\Users\Application\Search;

use Hexa\Users\Application\UserResponse;
use Hexa\Users\Domain\{ UserNotExist, UserRepository };
use Hexa\Shared\Domain\Bus\Query\QueryHandler;

final class SearchUserQueryHandler implements QueryHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(SearchUserQuery $query): UserResponse
    {
        $user = $this->repository->search($query->firstname(),$query->lastname(),$query->email());

        $this->ensureUserExists($user);

        return new UserResponse(
            $user->id(),
            $user->firstname(),
            $user->lastname(),
            $user->email(),
            $user->image()
        );
    }

    private function ensureUserExists($user)
    {
        if ( null === $user ) throw new UserNotExist(0);
    }
}

