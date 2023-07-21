<?php

namespace Hexa\PasswordResets\Domain;

final class PasswordReset
{
    private $email;
    private $token;

    public function __construct(
        string $email,
        string $token
    ) {

        $this->email = $email;
        $this->token = $token;
    }

    public static function create(
        $email,
        $token
    ): self {

        return new self(
            $email,
            $token
        );
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
