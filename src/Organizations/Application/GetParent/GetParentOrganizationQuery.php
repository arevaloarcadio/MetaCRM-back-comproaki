<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application\GetParent;

use Hexa\Shared\Domain\Bus\Query\Query;

final class GetParentOrganizationQuery implements Query
{
	private $user_id;
	private $unit_id;

    public function __construct(int $user_id,int $unit_id)
    {
        $this->user_id = $user_id;
        $this->unit_id = $unit_id;
    }

    public function user_id(): int
    {
        return $this->user_id;
    }

    public function unit_id(): int
    {
        return $this->unit_id;
    }

}
