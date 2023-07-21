<?php

namespace Hexa\Hosts\Domain;

final class Host
{
    private $id;
    private $domain;

    public function __construct(int $id, string $domain)
    {
        $this->id = $id;
        $this->domain = $domain;
    }

    public static function create($domain): self
    {
        return new self(0001, $domain);
    }

    public static function update($id, $domain): self
    {
        return new self($id, $domain);
    }

    public function id(): int
    {
        return $this->id;
    }

    public function domain(): string
    {
        return $this->domain;
    }
}
