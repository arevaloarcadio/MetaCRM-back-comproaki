<?php

declare(strict_types = 1);

namespace Hexa\PasswordResets\Application;

use Hexa\Shared\Domain\Bus\Query\Response;

final class PasswordResetsResponse implements Response
{
    private $password_resets;

    public function __construct(PasswordResetResponse ...$password_resets)
    {
        $this->password_resets = $password_resets;
    }

    public function password_resets(): array
    {
        return $this->password_resets;
    }
}
