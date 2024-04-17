<?php

namespace Sfneal\Dependencies\Providers;

use Illuminate\Support\ServiceProvider;

class DependenciesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any Dependencies services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish config file
        $this->publishes([
            __DIR__.'/../../config/dependencies.php' => config_path('dependencies.php'),
        ], 'config');
    }

    /**
     * Register any Dependencies services.
     *
     * @return void
     */
    public function register(): void
    {
        // Load config file
        $this->mergeConfigFrom(__DIR__.'/../../config/dependencies.php', 'dependencies');
    }
}
