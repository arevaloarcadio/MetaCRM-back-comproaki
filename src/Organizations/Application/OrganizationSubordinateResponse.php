<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class OrganizationSubordinateResponse implements Response
{
    public function __construct($id)
    {
        $this->id = $id;
       
    }
}

