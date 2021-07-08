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
    public function boot()
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
    public function register()
    {
        // Load config file
        $this->mergeConfigFrom(__DIR__.'/../../config/dependencies.php', 'dependencies');
    }
}
