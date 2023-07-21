<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\SearchNoParent;

use function \Lambdish\Phunctional\map;
use Hexa\Users\Domain\UserRepository;
use Hexa\Users\Application\{ UserResponse, UsersResponse };

final class NoParentUsersSearcher
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function searchNoParent($host_id): UsersResponse
    {
        return new UsersResponse(...map($this->toResponse(), $this->repository->searchNoParent($host_id)));
    }

    private function toResponse(): callable
    {
        return static function ($user) {
            return new UserResponse($user['id'], $user['firstname'], $user['lastname'], $user['email'],$user['image'],$user['admin'],$user['active'],null,null,$user['organizations']);
        };
    }
}
