<?php

declare(strict_types = 1);

namespace Hexa\Units\Domain;

use Hexa\Shared\Domain\DomainError;

final class UnitNotExist extends DomainError
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'unit_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The unit <%s> does not exist', $this->id);
    }
}
