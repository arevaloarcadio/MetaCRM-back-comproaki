<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\SearchByHostAll;

use function \Lambdish\Phunctional\map;
use Hexa\Users\Domain\UserRepository;
use Hexa\Users\Application\{ UserResponse, UsersResponse };

final class ByHostAllUsersSearcher
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function searchByHostAll($host_id = null): UsersResponse
    {
        return new UsersResponse(...map($this->toResponse(), $this->repository->searchByHostAll($host_id)));
    }

    private function toResponse(): callable
    {
        return static function ($user) {
            return new UserResponse($user['id'], $user['firstname'], $user['lastname'], $user['email'],$user['image'],$user['admin'],$user['active'],$user['domain'],$user['host_id']);
        };
    }
}
