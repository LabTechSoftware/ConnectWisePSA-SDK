<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use SoapClient;
use InvalidArgumentException;

class ConnectwiseApiFactory
{
    /**
     * Path to config file
     *
     * @var string
     */
    private $config = '';

    /**
     * Set path to a default config file
     *
     * @return \LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory
     */
    public function __construct()
    {
        $this->config = __DIR__ . '/config/config.ini';
    }

    /**
     * Create new instance of a specified API class
     * Optionally pass in a new config path
     *
     * @throws \LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @throws \InvalidArgumentException
     * @param string $api
     * @param string $configPath
     * @return object
     */
    public function make($api, $configPath = '')
    {
        // Check for proper value type for API variable
        // We don't do this for the 2nd variable (config) since we may not need it
        if (is_string($api) === false) {
            throw new InvalidArgumentException('Expecting string value.');
        }

        // Set the config path value if one was passed in
        if (strlen($configPath) > 0) {
            $this->setConfig($configPath);
        }

        // All lowercase, then capitalize first character
        $apiNamespace = "LabtechSoftware\\ConnectwisePsaSdk\\$api";

        // Die a horrible death if the class does not exist
        if (class_exists($apiNamespace) === false) {
            throw new ApiException('Class does not exist');
        }

        return new $apiNamespace($this->wireDependencies($api.'API'));
    }

    /**
     * Set the config path
     *
     * @throws \InvalidArgumentException
     * @throws \LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @param string $config
     * @return void
     */
    private function setConfig($config)
    {
        // Expecting string value
        if (is_string($config) === false) {
            throw new InvalidArgumentException('Expecting string value.');
        }

        // Check path for file existence
        if (file_exists($config) === false) {
            throw new ApiException('Failed to load config on given path.');
        }

        // Set the config value as class param
        $this->config = $config;
    }

    /**
     * Load the config file, set up a SoapClient instance and prepare for a request
     *
     * @throws \InvalidArgumentException
     * @param string $apiName
     * @return \LabtechSoftware\ConnectwisePsaSdk\SoapApiRequester
     */
    private function wireDependencies($apiName)
    {
        if (is_string($apiName) === false || strlen($apiName) < 1) {
            throw new InvalidArgumentException(
                'Expecting string value with required amount of characters.'
            );
        }

        // Load the config file using the set path
        $cl = new ConfigLoader();
        $cl->loadConfig($this->config);

        // New SoapClient instance
        $soap = new SoapClient(
            $cl->getSoapAddress($apiName),
            $cl->getSoapOptions()
        );

        return new SoapApiRequester($soap, $cl);
    }
}