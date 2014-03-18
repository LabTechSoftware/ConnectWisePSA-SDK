<?php namespace LabtechSoftware\ConnectwisePsaSdk\Laravel;

use Illuminate\Support\Facades\Facade;

class ConnectwiseApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApi';
    }
}
