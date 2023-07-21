<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class OrganizationsParentResponse implements Response
{
    private $organizations;

    public function __construct(OrganizationParentResponse ...$organizations)
    {
        $this->organizations = $organizations;
    }

    public function organizations(): array
    {
        return $this->organizations;
    }
}
