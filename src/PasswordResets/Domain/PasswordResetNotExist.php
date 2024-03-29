<?php

declare(strict_types = 1);

namespace Hexa\PasswordResets\Domain;

use Hexa\Shared\Domain\DomainError;

final class PasswordResetNotExist extends DomainError
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'user_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The user <%s> does not exist', $this->id);
    }
}
