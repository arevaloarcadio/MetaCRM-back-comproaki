<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class HostsResponse implements Response
{
    private $hosts;

    public function __construct(HostResponse ...$hosts)
    {
        $this->hosts = $hosts;
    }

    public function Hosts(): array
    {
        return $this->hosts;
    }
}
