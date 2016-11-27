<?php

namespace Premise\Laralang;

use Illuminate\Support\ServiceProvider;

class LaralangServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->publishes([
            __DIR__.'/Config/laralang.php' => config_path('laralang.php'),
            __DIR__.'/Assets'              => public_path('vendor/Premise/Laralang'),
        ], 'laralang_pkg');

        $router->middleware('laralang.middleware', config('laralang.default.middleware'));

        $this->loadTranslationsFrom(__DIR__.'/translations', 'laralang');
        $this->loadMigrationsFrom(__DIR__.'/Migrations', 'laralang');

        $this->loadViewsFrom(__DIR__.'/Views', 'laralang');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
