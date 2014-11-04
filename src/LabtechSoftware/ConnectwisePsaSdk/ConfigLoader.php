<?php


namespace LabtechSoftware\ConnectwisePsaSdk;


class ConfigLoader
{
    private $config = array();

    public function loadConfig($config)
    {
        if (is_string($config) === true) {
            $this->isValidPath($config);
            $this->set($this->load($config));
        } elseif (is_array($config) === true) {
            $this->validateConfigItems($config);
            $this->set($config);
        } else {
            throw new ApiException('Expecting string or array value.');
        }
    }

    protected function validateConfigItems(array $configValues)
    {
        // Check for items in array
        if (count($configValues) < 1) {
            throw new ApiException('Configuration is empty.');
        }

        return true;
    }

    public function load($path = '')
    {
        $config = array();
        foreach (parse_ini_file($path, true) as $key => $val) {
            $config[$key] = $val;
        }

        // Validate the config file
        // Throws exception on failure
        $this->validateConfigItems($config);

        return $config;
    }

    public function set(array $configArray = array())
    {
        $this->config = $configArray;
    }

    protected function isValidPath($fullPath)
    {
        // Check for invalid path via is_file()
        // Throw exception if false (path invalid)
        if (is_file($fullPath) === false) {
            throw new ApiException('Config file not found.');
        }

        return true;
    }

    public function getSoapOptions()
    {
        return $this->config['soap'];
    }

    public function getSoapAddress($apiName)
    {
        return sprintf($this->config['url']['cw_api_main'], $this->config['credentials']['domain'], $apiName);
    }

    public function getSoapCredentials()
    {
        return $this->config['credentials'];
    }
}
