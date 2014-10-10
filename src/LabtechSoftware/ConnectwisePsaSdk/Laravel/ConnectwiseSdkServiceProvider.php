<?php namespace LabtechSoftware\ConnectwisePsaSdk\Laravel;

use Illuminate\Support\ServiceProvider;
use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFacotry;

class ConnectwiseSdkServiceProvider extends ServiceProvider
{
    public function register()
    {
/*        $this->app->bind('LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory', function () {
            return new LabtechSoftware\ConnectwisePsaSdk\ConnnectwiseApiFactory;
        });*/

        $this->app['connectwise-psa-sdk'] = $this->app->share(function ($app) {
            return new ConnectwiseApiFacotry(
                $app['config']['connectwise-psa-sdk::api']
            );
        });
    }

    public function boot()
    {
        $this->package('labtech-software/connectwise-psa-sdk', 'connectwise-psa-sdk');
    }

    public function provides()
    {
        return array('connectwise-psa-sdk');
    }
}
