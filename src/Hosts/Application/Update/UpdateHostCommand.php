<?php

namespace Hexa\Hosts\Application\Update;

use Hexa\Shared\Domain\Bus\Command\Command;

final class UpdateHostCommand implements Command
{
    private $id;
    private $domain;

    public function __construct(int $id, string $domain)
    {
        $this->id = $id;
        $this->domain = $domain;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function domain(): string
    {
        return $this->domain;
    }
}
