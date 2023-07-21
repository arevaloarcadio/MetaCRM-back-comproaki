<?php

declare(strict_types = 1);

namespace Hexa\Units\Domain;

interface UnitRepository
{
    public function save(Unit $unit): void;

    public function find(int $id): ?Unit;

    public function searchAll(int $user_id): array;

    public function delete(int $id): void;
}
