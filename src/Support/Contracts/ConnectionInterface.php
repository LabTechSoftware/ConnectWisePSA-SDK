<?php namespace LabtechSoftware\ConnectwisePsaSdk\Support\Contracts;

/**
 * Contract for Connection classes
 * All connection classes should implement this interface!
 */
interface ConnectionInterface
{
    public function makeRequest($method, $params);
}