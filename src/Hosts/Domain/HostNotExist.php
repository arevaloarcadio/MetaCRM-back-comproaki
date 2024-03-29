<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Domain;

use Hexa\Shared\Domain\DomainError;

final class HostNotExist extends DomainError
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'Host_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The Host <%s> does not exist', $this->id);
    }
}
