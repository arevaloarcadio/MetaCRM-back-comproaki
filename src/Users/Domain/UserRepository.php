<?php

declare(strict_types = 1);

namespace Hexa\Users\Domain;

interface UserRepository
{
    public function save(User $user): ?User;

    public function saveAuthProvider(User $user): ?User;

    public function find(int $id): ?User;

    public function findByEmail(string $email): ?User;
    
    public function searchAll(): array;

    public function searchNoParent($host_id): array;

    public function searchByHostAll($host_id = null): array;

    public function search(string $firstname,string $lastname,string $email): ?User;

    public function delete(int $id): void;

    public function update(User $user): void;

    public function updateActive(User $user): void;

    public function updatePassword(User $user): void;

    public function updateImage(User $user): void;
	
}
