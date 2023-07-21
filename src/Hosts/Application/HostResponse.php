<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class HostResponse implements Response
{
    public function __construct(int $id, string $domain)
    {
        $this->id = $id;
        $this->domain = $domain;
    }
}

