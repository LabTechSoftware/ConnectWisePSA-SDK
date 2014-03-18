<?php namespace LabtechSoftware\ConnectwisePsaSdk\Laravel;

use Illuminate\Support\ServiceProvider;

class ConnectwiseSdkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory', function () {
            return new LabtechSoftware\ConnectwisePsaSdk\ConnnectwiseApiFactory;
        });
    }
}
