<?php

namespace Hexa\Organizations\Application\Create;

use Hexa\Shared\Domain\Bus\Command\Command;

final class CreateOrganizationCommand implements Command
{
    private $parent_id;
    private $above_id;
    private $user_id;
    private $level;
    private $host_id;

    public function __construct( ?int $parent_id = null,?int $above_id = null, int $user_id, int $level, int $host_id)
    {
        $this->parent_id = $parent_id;
        $this->above_id = $above_id;
        $this->user_id = $user_id;
        $this->level = $level;
        $this->date = date("Y-m-d");
        $this->host_id = $host_id;
    }

    public function parent_id(): ?int
    {
        return $this->parent_id;
    }

    public function above_id(): ?int
    {
        return $this->above_id;
    }
    
    public function user_id(): int
    {
        return $this->user_id;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function date(): int
    {
        return $this->date;
    }

    public function host_id(): int
    {
        return $this->host_id;
    }
}
