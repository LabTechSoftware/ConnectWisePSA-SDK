<?php namespace ConnectWiseApi;

use ConnectWiseApi\ApiException;

/**
 * API Resource Container Goodness
 *
 * @package API
 */
class ApiResource
{
    /**
     * Resources go here
     *
     * @var array
     **/
    protected static $resources = array();

    /**
     * Add a class instance to the resources array
     *
     * @throws ApiException
     * @param string $key
     * @param object $classInstance
     * @return void
     */
    public static function setResource($key, $classInstance)
    {
        if (is_object($classInstance) === true)
        {
            static::$resources[$key] = $classInstance; 
            return;
        }
        
        throw new ApiException('Resources can only be objects.');
    }

    /**
     * Get a class instance from the resources array
     *
     * @throws ApiException
     * @param string $key
     * @return object
     */
    public static function getResource($key)
    {
        if (array_key_exists($key, static::$resources) === true)
        {
            return static::$resources[$key];            
        }

        throw new ApiException('Invalid resource key.');
    }

    /**
     * Run a method on a class instance stored in the resources array
     *
     * @throws ApiException
     * @param string $resourceKey
     * @param string $method
     * @param mixed $arguments
     * @return mixed
     */
    public static function run($resourceKey, $method, $arguments = null)
    {
        $objectInstance = static::getResource($resourceKey);
        
        if (method_exists($objectInstance, $method) === true)
        {
            return (is_null($arguments) === true) ? $objectInstance->$method() : $objectInstance->$method($arguments);
        }

        throw new ApiException('Method does not exist in resource.');
    }
}
