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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/main.php', 'sms-package'
        );

        $this->app->bind('seymuromarov-sms', function () {
            return new SmsGenerator();
        });
    }
}
