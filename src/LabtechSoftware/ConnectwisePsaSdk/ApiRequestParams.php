<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use stdClass;

/**
 * (simple) API Request Params Container
 *
 * @package ConnectwisePsaSdk
 */
class ApiRequestParams
{
    public static $params = array();

    /**
     * Set a parameter 
     *
     * @param mixed (string/integer) $key
     * @param mixed 
     * @return void
     */
    public static function set($key, $value)
    {
        static::$params[$key] = $value;
    }

    /**
     * Set multiple parameters
     *
     * @param array $params
     * @return void
     */
    public static function setMultiple(array $params)
    {
        foreach ($params as $paramKey => $paramVal)
        {
            static::set($paramKey, $paramVal);
        }
    }

    /**
     * Get a parameter
     *
     * @param mixed (string/integer)
     * @return mixed
     */
    public static function get($key)
    {
        return static::$params[$key];
    }

    /**
     * Get all parameters
     *
     * @return mixed
     */
    public static function getAll()
    {
        return static::$params;
    }

    /**
     * Get all parameters as an object (stdClass)
     *
     * @return stdClass
     */
    public static function getAllObject()
    {
        $retClass = new stdClass;

        foreach (static::getAll() as $parKey => $parVal)
        {
            $retClass->$parKey = $parVal;
        }

        return $retClass;
    }
}
