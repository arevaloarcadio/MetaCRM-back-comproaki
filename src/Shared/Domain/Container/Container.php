<?php

declare(strict_types = 1);

namespace Hexa\Shared\Domain\Container;

interface Container
{
    public function make($class);
}
