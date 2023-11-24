<?php

namespace ReesMcIvor\SecureLogin;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use ReesMcIvor\SecureLogin\Nova\TrustedDevice;

class SecureLoginPackageServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if($this->app->runningInConsole()) {
            $this->commands([
                \ReesMcIvor\SecureLogin\Console\Commands\ClearOldAttempts::class,
            ]);
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
                __DIR__ . '/../publish/tests' => base_path('tests/SecureLogin'),
                __DIR__ . '/../publish/config' => base_path('config'),
            ], 'laravel-secure-login');
        }

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        Nova::resources([
            TrustedDevice::class
        ]);

        $router = $this->app['router'];
        $router->aliasMiddleware('secure-login', \ReesMcIvor\SecureLogin\Http\Middleware\UnrecognisedLoginCheckMiddleware::class);
    }

    private function modulePath($path)
    {
        return __DIR__ . '/../../' . $path;
    }
}
