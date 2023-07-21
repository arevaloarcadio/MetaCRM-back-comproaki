<?php

declare(strict_types = 1);

namespace Hexa\PasswordResets\Application\Find;

use Hexa\Shared\Domain\Bus\Query\Query;

final class FindPasswordResetQuery implements Query
{
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function token(): string
    {
        return $this->token;
    }
}

