<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Domain;

use Hexa\Shared\Domain\DomainError;

final class OrganizationNotExist extends DomainError
{
    private $unit_id;

    public function __construct($unit_id)
    {
        $this->unit_id = $unit_id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'organization_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The organization <%s> does not exist', $this->unit_id);
    }
}
