<?php

declare(strict_types = 1);

namespace Hexa\Hosts\Domain;

interface HostRepository
{
    public function save(Host $host): void;

    public function find(int $id): ?Host;

    public function findByName(string $name): ?Host;

    public function searchAll(): array;

    public function delete(int $id): void;
}
