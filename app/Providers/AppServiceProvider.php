<?php

namespace App\Providers;

use Hexa\Shared\Domain\Bus\Command\CommandBus;
use Hexa\Shared\Domain\Bus\Query\QueryBus;
use Hexa\Shared\Domain\Container\Container;
use Hexa\Shared\Domain\Exception\ExceptionsCodeMapping;
use Hexa\Shared\Infrastructure\Api\Exception\ExceptionsHttpStatusCodeMapping;
use Hexa\Shared\Infrastructure\Bus\Command\SimpleCommandBus;
use Hexa\Shared\Infrastructure\Bus\Query\SimpleQueryBus;
use Hexa\Shared\Infrastructure\Container\LaravelContainer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ExceptionsCodeMapping::class,
            ExceptionsHttpStatusCodeMapping::class
        );

        /*$this->app->singleton(
            ExceptionHandler::class,
            HexaExceptionHandler::class
        );*/

        $this->app->bind(
            Container::class,
            LaravelContainer::class
        );

        $this->app->bind(
            QueryBus::class,
            SimpleQueryBus::class
        );

        $this->app->bind(
            CommandBus::class,
            SimpleCommandBus::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
