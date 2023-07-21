<?php

declare(strict_types = 1);

namespace Hexa\Users\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class UserResponse implements Response
{
    public function __construct(int $id, string $firstname, string $lastname, string $email,string $image, $admin = null,$active = null,$domain = null,$host_id = null,$organizations = null)
    {
        $this->id        = $id;
        $this->firstname = $firstname;
        $this->lastname  = $lastname;
        $this->email     = $email;
        $this->image     = $image;
    	$this->admin     = $admin;
    	$this->active    = $active;
        $this->domain    = $domain;
        $this->host_id   = $host_id;
        $this->organizations   = $organizations;
    }
}

