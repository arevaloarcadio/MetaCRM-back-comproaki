<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\Get;

use Hexa\Shared\Domain\Bus\Query\Query;

final class GetOrganizationQuery implements Query
{
	private $host_id;

    public function __construct(int $host_id)
    {
        $this->host_id = $host_id;
    }

    public function host_id(): int
    {
        return $this->host_id;
    }

}
