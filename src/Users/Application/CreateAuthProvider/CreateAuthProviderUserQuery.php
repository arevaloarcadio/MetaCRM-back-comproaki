<?php

namespace Hexa\Users\Application\CreateAuthProvider;

use Hexa\Shared\Domain\Bus\Query\Query;

final class CreateAuthProviderUserQuery implements Query
{
    private $firstname;
    private $lastname;
    private $email;
    private $auth_provider;

    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $auth_provider
    ) {

        $this->firstname = $firstname;
        $this->lastname  = $lastname;
        $this->email     = $email;
        $this->auth_provider = $auth_provider;
    }

    public function firstname(): string
    {
        return $this->firstname;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function auth_provider(): string
    {
        return $this->auth_provider;
    }
}
