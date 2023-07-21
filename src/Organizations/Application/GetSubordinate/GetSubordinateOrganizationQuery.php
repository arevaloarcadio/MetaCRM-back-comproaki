<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\GetSubordinate;

use Hexa\Shared\Domain\Bus\Query\Query;

final class GetSubordinateOrganizationQuery implements Query
{
	private $user_ids;
	private $unit_id;

    public function __construct(array $user_ids,int $unit_id)
    {
        $this->user_ids = $user_ids;
        $this->unit_id = $unit_id;
    }

    public function user_ids(): array
    {
        return $this->user_ids;
    }

    public function unit_id(): int
    {
        return $this->unit_id;
    }

}
