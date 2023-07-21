<?php

namespace Hexa\Organizations\Domain;

final class Organization
{
    private $id;
    private $parent_id;
    private $above_id;
    private $level;
    private $host_id;

    public function __construct(int $id, ?int $parent_id,?int $above_id, int $user_id, int $level, int $host_id)
    {
        $this->id = $id;
        $this->parent_id = $parent_id;
        $this->above_id = $above_id;
        $this->user_id = $user_id;
        $this->level = $level;
        $this->host_id = $host_id;
    }

    public static function create($parent_id,$above_id, $user_id, $level, $host_id): self
    {
        return new self(0001, $parent_id,$above_id, $user_id, $level, $host_id);
    }

    public static function update($id, $parent_id,$above_id,$user_id, $level, $host_id): self
    {
        return new self($id, $parent_id,$above_id, $user_id, $level, $host_id);
    }

    public function id(): int
    {
        return $this->id;
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

    public function host_id(): int
    {
        return $this->host_id;
    }
}
