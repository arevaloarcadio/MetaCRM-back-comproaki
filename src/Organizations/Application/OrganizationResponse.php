<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class OrganizationResponse implements Response
{
    public function __construct(int $id, ?int $parent_id,?int $above_id, int $user_id, int $level, int $host_id, $user = null, $parent = null, $host = null)
    {
        $this->id = $id;
        $this->parent_id = $parent_id;
        $this->above_id = $above_id;
        $this->user_id = $user_id;
        $this->level = $level;
        $this->host_id = $host_id;
        $this->user = $user;
        $this->parent = $parent;
        $this->host = $host;
    }
}

