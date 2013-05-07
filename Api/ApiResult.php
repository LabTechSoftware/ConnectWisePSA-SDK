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
        // Force all result data into an array
        if (is_array($result) === true OR is_object($result) === true)
        {
            $result = static::forceArray($result);
        }
        else
        {
            $result = array($result);
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

    /**
     * Convert a result object or result array containing objects to array(s)
     *
     * @param mixed (array/object) $resultObject
     * @return array
     **/
    public static function forceArray($resultData)
    {
        // Final result array goes here
        $returnArray = array();

        // If this is an object, do a get_object_vars() -- otherwise just use the array
        $convertedArray = (is_object($resultData) === true) ? get_object_vars($resultData) : $resultData;

        // Loop through $convertedArray to find children objects/arrays
        foreach ($convertedArray as $key => $val) 
        {
            if (is_array($val) === true OR is_object($val) === true)
            {
                $val = static::forceArray($val);
            }
            else
            {
                $val = $val;
            }

            $returnArray[$key] = $val;
        }

        return $returnArray;
    }
}