<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\SearchAll;

use Hexa\Shared\Domain\Bus\Query\Query;

final class SearchAllUsersQuery implements Query
{
	private $host_id;

    public function __construct()
    {
    	
    }

    public function host_id()
    {
        return $this->host_id;
    }
}
