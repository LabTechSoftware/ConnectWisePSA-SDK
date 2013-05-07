<?php namespace Api;

use stdClass;

/**
 * (simple) API Request Params Container
 *
 * @package API
 */
class ApiRequestParams
{
    public static $params = array();

    public static function set($key, $value)
    {
        static::$params[$key] = $value;
    }

    public static function setMany(array $params)
    {
        foreach ($params as $paramKey => $paramVal)
        {
            static::set($paramKey, $paramVal);
        }
    }

    public static function get($key)
    {
        static::$params[$key];
    }

    public static function getAll()
    {
        return static::$params;
    }

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
