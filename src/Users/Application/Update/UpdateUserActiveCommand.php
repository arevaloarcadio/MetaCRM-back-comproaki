<?php

namespace Hexa\Users\Application\Update;

use Hexa\Shared\Domain\Bus\Command\Command;

final class UpdateUserActiveCommand implements Command
{
    private $userId;
    private $active;

    public function __construct(
        int $userId,
        $active
    ) {

        $this->userId   = $userId;
        $this->active = $active;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function active()
    {
        return $this->active;
    }
}
