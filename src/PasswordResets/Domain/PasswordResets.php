<?php

namespace Hexa\PasswordResets\Domain;

final class PasswordResets
{
    protected function type(): string
    {
        return PasswordReset::class;
    }
}
