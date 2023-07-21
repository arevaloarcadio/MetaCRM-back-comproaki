<?php

namespace Hexa\Users\Application\Update;

use Hexa\Shared\Domain\Bus\Command\Command;

final class UpdateUserPasswordCommand implements Command
{
    private $userId;
    private $password;

    public function __construct(
        int    $userId,
        string $password
    ) {

        $this->userId   = $userId;
        $this->password = $password;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function password(): string
    {
        return $this->password;
    }
}
