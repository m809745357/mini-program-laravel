<?php

namespace M809745357\MiniProgram;

use Illuminate\Support\ServiceProvider;

class MiniProgramServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/miniprogram.php' => config_path('miniprogram.php'),
        ], 'mini-program-config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'mini-program-migrations');
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
