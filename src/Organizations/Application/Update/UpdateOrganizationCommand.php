<?php

namespace Hexa\Organizations\Application\Update;

use Hexa\Shared\Domain\Bus\Command\Command;

final class UpdateOrganizationCommand implements Command
{
    private $id;
    private $parent_id;
    private $above_id;
    private $user_id;
    private $level;
    private $unit_id;

    public function __construct(int $id, int $parent_id, int $above_id,int $user_id, int $level, int $unit_id)
    {
        $this->id = $id;
        $this->parent_id = $parent_id;
        $this->above_id = $above_id;
        $this->user_id = $user_id;
        $this->level = $level;
        $this->unit_id = $unit_id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function parent_id(): int
    {
        return $this->parent_id;
    }


    public function above_id(): int
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

    public function unit_id(): int
    {
        return $this->unit_id;
    }
}
