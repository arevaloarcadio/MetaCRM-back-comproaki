<?php

namespace Hexa\Shared\Infrastructure\Container;

use Illuminate\Container\Container as IoC;
use Hexa\Shared\Domain\Container\Container;

final class LaravelContainer implements Container
{
    private $container;

    public function __construct(IoC $container)
    {
        $this->container = $container;
    }

    public function make($class)
    {
        return $this->container->make($class);
    }
}
