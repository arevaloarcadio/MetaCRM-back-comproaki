<?php

declare(strict_types = 1);

namespace Hexa\Units\Application\SearchAll;

use Hexa\Shared\Domain\Bus\Query\Query;

final class SearchAllUnitsQuery implements Query
{
	private $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function user_id(): int
    {
        return $this->user_id;
    }
}
