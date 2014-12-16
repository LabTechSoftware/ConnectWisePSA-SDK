<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use SoapClient;
use InvalidArgumentException;

class ConnectwiseApiFactory
{
    /**
     * Create new instance of a specified API class
     * Optionally pass in a new config path
     *
     * @throws \LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @throws \InvalidArgumentException
     * @param string $api
     * @param string|array $config
     * @return object
     */
    public function make($api, $config = '')
    {
//        throw new \Exception('Duh');
        // Check for proper value type for API variable
        // We don't do this for the 2nd variable (config) since we may not need it
        if (is_string($api) === false) {
            throw new InvalidArgumentException('Expecting string value.');
        }

        $apiNamespace = "LabtechSoftware\\ConnectwisePsaSdk\\$api";

        // Die a horrible death if the class does not exist
        if (class_exists($apiNamespace) === false) {
            throw new ApiException('Class does not exist');
        }

        return new $apiNamespace($this->wireDependencies($api.'API', $config));
    }

    /**
     * Load the config file, set up a SoapClient instance and prepare for a request
     *
     * @throws \InvalidArgumentException
     * @param string $apiName
     * @param string|array $config
     * @return \LabtechSoftware\ConnectwisePsaSdk\SoapApiRequester
     */
    private function wireDependencies($apiName, $config)
    {
        if (is_string($apiName) === false || strlen($apiName) < 1) {
            throw new InvalidArgumentException(
                'Expecting string value with required amount of characters.'
            );
        }

        // Load the config file using the set path
        $cl = new ConfigLoader();
        $cl->loadConfig($config);

        // New SoapClient instance
        $soap = new SoapClient(
            $cl->getSoapAddress($apiName),
            $cl->getSoapOptions()
        );

        return new SoapApiRequester($soap, $cl);
    }
}
