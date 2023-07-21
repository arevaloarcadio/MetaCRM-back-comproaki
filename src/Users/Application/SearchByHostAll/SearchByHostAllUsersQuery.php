<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\SearchByHostAll;

use Hexa\Shared\Domain\Bus\Query\Query;

final class SearchByHostAllUsersQuery implements Query
{
	private $host_id;

    public function __construct($host_id = null)
    {
    	$this->host_id 	= $host_id;
    }

    public function host_id()
    {
        return $this->host_id;
    }
}
