<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class OrganizationParentResponse implements Response
{
    public function __construct($parent_id,$user_id)
    {
        $this->parent_id = $parent_id;
        $this->user_id = $user_id;
    }
}

