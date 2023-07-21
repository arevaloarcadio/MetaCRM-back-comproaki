<?php

declare(strict_types = 1);

namespace Hexa\Units\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class UnitsResponse implements Response
{
    private $units;

    public function __construct(UnitResponse ...$units)
    {
        $this->units = $units;
    }

    public function units(): array
    {
        return $this->units;
    }
}
