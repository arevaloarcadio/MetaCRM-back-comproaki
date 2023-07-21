<?php

namespace Hexa\Users\Application\Update;

use Hexa\Shared\Domain\Bus\Command\Command;

final class UpdateUserImageCommand implements Command
{
    private $userId;
    private $image;

    public function __construct(
        int    $userId,
        string $image
    ) {

        $this->userId   = $userId;
        $this->image = $image;
        
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function image(): string
    {
        return $this->image;
    }
}
