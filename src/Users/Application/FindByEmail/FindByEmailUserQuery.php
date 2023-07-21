<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\FindByEmail;

use Hexa\Shared\Domain\Bus\Query\Query;

final class FindByEmailUserQuery implements Query
{
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function email(): string
    {
        return $this->email;
    }
}

