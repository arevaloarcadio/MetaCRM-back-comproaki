<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class OrganizationsResponse implements Response
{
    private $organizations;

    public function __construct(OrganizationResponse ...$organizations)
    {
        $this->organizations = $organizations;
    }

    public function organizations(): array
    {
        return $this->organizations;
    }
}
