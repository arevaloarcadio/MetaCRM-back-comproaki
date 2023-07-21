<?php

declare(strict_types = 1);

namespace Hexa\Units\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class UnitResponse implements Response
{
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

