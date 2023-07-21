<?php

namespace Hexa\PasswordResets\Application\Create;

use Hexa\Shared\Domain\Bus\Query\Query;

final class CreatePasswordResetQuery implements Query
{
    private $email;
    private $token;

    public function __construct(
        string $email,
        string $token
    ) {

        $this->email = $email;
        $this->token  = $token;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function token(): string
    {
        return $this->token;
    }
}
