<?php

declare(strict_types = 1);

namespace Hexa\Users\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class UsersResponse implements Response
{
    private $users;

    public function __construct(UserResponse ...$users)
    {
        $this->users = $users;
    }

    public function users(): array
    {
        return $this->users;
    }
}
