<?php

namespace Kevindierkx\GravatarHelper\Providers;

use Illuminate\Support\ServiceProvider;
use Kevindierkx\GravatarHelper\Gravatar;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the package config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $path = realpath(__DIR__."/../../config/gravatar-helper.php");

        $this->publishes([$path => config_path("gravatar-helper.php")]);

        $this->mergeConfigFrom($path, 'gravatar-helper');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gravatar-helper', function ($app) {
            return new Gravatar(
                $app['config']->get('gravatar-helper.size'),
                $app['config']->get('gravatar-helper.rating'),
                $app['config']->get('gravatar-helper.image_set')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['gravatar-helper'];
    }
}
