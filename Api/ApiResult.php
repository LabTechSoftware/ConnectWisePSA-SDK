<?php namespace Api;

use Api\ApiException;

/**
 * API Results Storage
 * Results always stored in an array!
 *
 * @package API
 **/
class ApiResult
{
    public static $data = array();

    /**
     * Add a result
     *
     * @param mixed $result
     * @return void
     */
    public static function addResult($result)
    {
        // If object, convert to array
        if (is_object($result) === true)
        {
            $result = json_decode(json_encode($result), true);
        }

        static::$data = $result;
    }

    /**
     * Add multiple results
     *
     * @param array $results
     * @return void
     */
    public static function addResults(array $results)
    {
        foreach ($results as $res)
        {
            static::addResult($res);
        } 
    }

    /**
     * Get one of the results from the data array
     *
     * @throws ApiException
     * @param string $key
     * @return mixed
     */
    public static function getOne($key)
    {
        return static::$data[$key];
    }

    /**
     * Get all of the results
     *
     * @return array
     */
    public static function getAll()
    {
        return static::$data;
    }
}