<?php namespace Api;

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

    public static function get($key)
    {
        static::$params[$key];
    }

    public static function getAll()
    {
        return static::$params;
    }
}
