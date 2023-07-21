<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Application\FindByName;

use Hexa\Shared\Domain\Bus\Query\Query;

final class FindByNameHostQuery implements Query
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}

