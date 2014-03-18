<?php namespace LabtechSoftware\ConnectwisePsaSdk\Laravel;

use Illuminate\Support\Facades\Facade;

class ConnectwiseFactory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory';
    }
}
