<?php

declare(strict_types = 1);

namespace Hexa\PasswordResets\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class PasswordResetResponse implements Response
{
    public function __construct(string $email, string $token)
    {
        $this->email = $email;
        $this->token = $token;
    }
}

