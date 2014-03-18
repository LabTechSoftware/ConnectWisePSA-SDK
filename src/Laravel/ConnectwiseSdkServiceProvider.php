<?php namespace LabtechSoftware\ConnectwisePsaSdk\Laravel;

use Illuminate\Support\ServiceProvider;

class ConnectwiseSdkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApi', 
            function () {
                return new LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApi;
            }
        );
    }
}
