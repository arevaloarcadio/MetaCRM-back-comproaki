<?php

namespace Hexa\Units\Domain;

final class Unit
{
    private $id;
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create($name): self
    {
        return new self(0001, $name);
    }

    public static function update($id, $name): self
    {
        return new self($id, $name);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
