<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    
    protected $namespace = 'App\Http\Controllers';

    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
           /* Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));*/

            Route::pattern('domain', '[a-z0-9.\]+');
            // Auth
            
            Route::namespace($this->namespace)
                ->prefix('auth')
                ->group(base_path('routes/auth/auth.php'));

            // Users
            Route::namespace($this->namespace)
                ->prefix('units')
                ->group(base_path('routes/units/units.php'));

            Route::namespace($this->namespace)
                ->prefix('hosts')
                ->group(base_path('routes/hosts/hosts.php'));

            Route::namespace($this->namespace)
                ->prefix('users')
                ->group(base_path('routes/users/users.php'));

            // Organizations
            Route::namespace($this->namespace)
                ->prefix('organizations')
                ->group(base_path('routes/organizations/organizations.php'));

            Route::namespace($this->namespace)
                ->prefix('password-resets')
                ->group(base_path('routes/password-resets/password-resets.php'));

            Route::namespace($this->namespace)
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }


}
