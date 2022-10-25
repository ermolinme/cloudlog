<?php

namespace Ermolinme\CloudLog;

use Illuminate\Support\ServiceProvider;

class CloudLogServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cloud_log.php', 'cloud_log');
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../config/cloud_log.php' => config_path('cloud_log.php')], 'config');
    }
}
