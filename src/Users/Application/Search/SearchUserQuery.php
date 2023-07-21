<?php

declare(strict_types = 1);

namespace Hexa\Users\Application\Search;

use Hexa\Shared\Domain\Bus\Query\Query;

final class SearchUserQuery implements Query
{

	private $firstname;
    private $lastname;
    private $email;

    public function __construct(string $firstname,string $lastname,string $email)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
    }

    public function firstname(): string
    {
        return $this->firstname;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }

    public function email(): string
    {
        return $this->email;
    }
}
