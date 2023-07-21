<?php

namespace Hexa\Users\Domain;

final class Users
{
    protected function type(): string
    {
        return User::class;
    }
}
