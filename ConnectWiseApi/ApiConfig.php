<?php namespace ConnectWiseApi;

use ConnectWiseApi\ApiException;

/**
 * API Config
 *
 * @package API
 */
class ApiConfig
{
    protected static $configDir = null;

    /**
     * Set the config directory path
     * This class will use the directory to find config files
     *
     * @param string $pathToDir
     * @return void
     */
    public static function setConfigDirPath($pathToDir)
    {
        static::$configDir = $pathToDir;
    }

    /**
     * Get a config item/file
     *
     * @throws ApiException
     * @param string $filename
     * @param string $item
     * @param mixed $returnDefault
     * @return mixed
     */
    public static function get($filename, $item = null, $returnDefault = null)
    {
        $path = static::$configDir . '/' . $filename . '.php';

        if (file_exists($path) === false OR is_readable($path) === false)
        {
            throw new ApiException('Unable to load config file at: ' . $path);
        }

        $loadConfigFile = require($path);

        // Get all config items from file if $item is null
        if (is_null($item) === true)
        {
            return $loadConfigFile;
        }

        // Load a specific config item from file
        if (array_key_exists($item, $loadConfigFile) === true)
        {
            return $loadConfigFile[$item];
        }
        
        // Return default value if we got this far
        return $returnDefault;
    }
}