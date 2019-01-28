<?php

namespace Seymuromarov\Sms;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/sms.php' => config_path('sms.php'),
        ], 'config');


        $this->loadMigrationsFrom(__DIR__.'/Migrations');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/sms.php', 'sms-package'
        );

        $this->app->bind('seymuromarov-sms', function () {
            return new SmsGenerator();
        });
    }
}
