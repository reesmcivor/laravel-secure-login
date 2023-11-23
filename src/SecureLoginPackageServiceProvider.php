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
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
                __DIR__ . '/../publish/tests' => base_path('tests/SecureLogin'),
            ], 'laravel-secure-login');
        }

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        Nova::resources([
            TrustedDevice::class
        ]);
    }

    private function modulePath($path)
    {
        return __DIR__ . '/../../' . $path;
    }
}
