<?php


namespace LabtechSoftware\ConnectwisePsaSdk;


class ConfigLoader
{
    private $config = array();

    /**
     * @param string|array $config Config to be used, string path, array config or empty string for default
     * @throws ApiException
     */
    public function loadConfig($config = '')
    {
        // check the passed in value, should be string or array
        if (!is_string($config) && !is_array($config)) {
            throw new ApiException('Expecting string or array value.');
        }

        // if config is string, we need to validate the path and load to array
        // if config is empty string, try to use the package's default config
        if (is_string($config)) {
            if (empty($config)) {
                $config = __DIR__ . '/config/config.php';
            }

            $this->isValidPath($config);
            $config = $this->load($config);
        }

        $this->validateConfigItems($config);
        $this->config = $config;
    }

    protected function validateConfigItems(array $configValues)
    {
        // soap array
        if (!array_key_exists('soap', $configValues) || !is_array($configValues['soap'])) {
            throw new ApiException(
                'Configuration array must be indexed with soap and its type must be array'
            );
        }

        if (!array_key_exists('soap_version', $configValues['soap']) ||
            !is_integer($configValues['soap']['soap_version'])
        ) {
            throw new ApiException(
                'soap array must be indexed with soap_version and its type must be integer'
            );
        }

        if (!array_key_exists('exceptions', $configValues['soap']) ||
            !is_bool($configValues['soap']['exceptions'])
        ) {
            throw new ApiException(
                'soap array must be indexed with exceptions and its type must be boolean'
            );
        }

        if (!array_key_exists('trace', $configValues['soap']) || !is_integer($configValues['soap']['trace'])) {
            throw new ApiException(
                'soap array must be indexed with trace and its type must be integer'
            );
        }

        if (!array_key_exists('cache_wsdl', $configValues['soap']) ||
            !is_integer($configValues['soap']['cache_wsdl'])
        ) {
            throw new ApiException(
                'soap array must be indexed with cache_wsdl and its type must be integer'
            );
        }

        // url array
        if (!array_key_exists('url', $configValues) || !is_array($configValues['url'])) {
            throw new ApiException(
                'Configuration array must be indexed with url and its type must be array'
            );
        }

        if (!array_key_exists('cw_api_main', $configValues['url']) ||
            !is_string($configValues['url']['cw_api_main']) ||
            empty($configValues['url']['cw_api_main'])
        ) {
            throw new ApiException(
                'url array must be indexed with cw_api_main and its type must be string'
            );
        }

        // credentials array
        if (!array_key_exists('credentials', $configValues) ||!is_array($configValues['credentials'])) {
            throw new ApiException(
                'Configuration array must be indexed with credentials and its type must be array'
            );
        }

        if (!array_key_exists('domain', $configValues['credentials']) ||
            !is_string($configValues['credentials']['domain']) ||
            empty($configValues['credentials']['domain'])
        ) {
            throw new ApiException(
                'credentials array must be indexed with domain and its type must be string'
            );
        }

        if (!array_key_exists('CompanyId', $configValues['credentials']) ||
            !is_string($configValues['credentials']['CompanyId']) ||
            empty($configValues['credentials']['CompanyId'])
        ) {
            throw new ApiException(
                'credentials array must be indexed with CompanyId and its type must be string'
            );
        }

        if (!array_key_exists('IntegratorLoginId', $configValues['credentials']) ||
            !is_string($configValues['credentials']['IntegratorLoginId']) ||
            empty($configValues['credentials']['IntegratorLoginId'])
        ) {
            throw new ApiException(
                'credentials array must be indexed with IntegratorLoginId and its type must be string'
            );
        }

        if (!array_key_exists('IntegratorPassword', $configValues['credentials']) ||
            !is_string($configValues['credentials']['IntegratorPassword']) ||
            empty($configValues['credentials']['IntegratorPassword'])
        ) {
            throw new ApiException(
                'credentials array must be indexed with IntegratorPassword and its type must be string'
            );
        }

        return true;
    }

    /**
     * @param string $path
     * @return array
     * @throws ApiException
     */
    protected function load($path = '')
    {
        $config = include $path;

        if (!is_array($config)) {
            throw new ApiException('config file is not formatted correctly');
        }

        return $config;
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
