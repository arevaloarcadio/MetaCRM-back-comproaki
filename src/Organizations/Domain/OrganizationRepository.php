<?php

declare(strict_types = 1);

namespace Hexa\Organizations\Domain;

interface OrganizationRepository
{
    public function save(Organization $organization): void;

    public function find(int $unit_id): ?Organization;

    public function searchAll(): array;
    
    public function getSubordinate(array $user_ids,int $unit_id): array;

    public function get(int $host_id): array;
    
    public function getParent(int $user_id,int $unit_id): ?Organization;
    
	public function delete(int $id): void;
}
