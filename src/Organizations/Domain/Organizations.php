<?php

namespace Hexa\Organizations\Domain;

final class Organizations
{
    protected function type(): string
    {
        return Organization::class;
    }
}
