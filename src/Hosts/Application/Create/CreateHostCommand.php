<?php

namespace Hexa\Hosts\Application\Create;

use Hexa\Shared\Domain\Bus\Command\Command;

final class CreateHostCommand implements Command
{
    private $domain;

    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    public function domain(): string
    {
        return $this->domain;
    }
}
