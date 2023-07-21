<?php

declare(strict_types = 1);

namespace Hexa\PasswordResets\Domain;

interface PasswordResetRepository
{
    public function save(PasswordReset $user): ?PasswordReset;

    public function find(string $token): ?PasswordReset;

    public function findByEmail(string $email): ?PasswordReset;

    public function delete(string $email): void;
}
