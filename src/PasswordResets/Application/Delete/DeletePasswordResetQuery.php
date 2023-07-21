<?php

declare(strict_types = 1);

namespace Hexa\PasswordResets\Application\Delete;

use Hexa\Shared\Domain\Bus\Query\Query;

final class DeletePasswordResetQuery implements Query
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

