<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Hexa\Users\Domain\UserRepository;
use Hexa\Users\Infrastructure\Persistence\EloquentUserRepository;

use Hexa\Units\Domain\UnitRepository;
use Hexa\Units\Infrastructure\Persistence\EloquentUnitRepository;

use Hexa\Organizations\Domain\OrganizationRepository;
use Hexa\Organizations\Infrastructure\Persistence\EloquentOrganizationRepository;

use Hexa\PasswordResets\Domain\PasswordResetRepository;
use Hexa\PasswordResets\Infrastructure\Persistence\EloquentPasswordResetRepository;

use Hexa\Hosts\Domain\HostRepository;
use Hexa\Hosts\Infrastructure\Persistence\EloquentHostRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            UserRepository::class,
            EloquentUserRepository::class
        );

        $this->app->bind(
            UnitRepository::class,
            EloquentUnitRepository::class
        );

        $this->app->bind(
            OrganizationRepository::class,
            EloquentOrganizationRepository::class
        );

        $this->app->bind(
            PasswordResetRepository::class,
            EloquentPasswordResetRepository::class
        );

        $this->app->bind(
            HostRepository::class,
            EloquentHostRepository::class
        );
    }
}