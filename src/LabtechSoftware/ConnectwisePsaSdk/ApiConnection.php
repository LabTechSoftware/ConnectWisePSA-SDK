<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use SoapClient,
    LabtechSoftware\ConnectwisePsaSdk\ApiException;

// SOAP Runtime settings: Turn off cache (0)
// See: http://www.php.net/manual/en/soap.configuration.php
ini_set('soap.wsdl_cache_enabled', '0');
ini_set('soap.wsdl_cache_ttl', '0');

/**
 * API (SOAP) Connection
 *
 * @package ConnectwisePsaSdk
 */
class ApiConnection
{
    protected $apiName = null;
    protected $address = null;
    protected $fullAddress = null;
    protected $domain = null;
    public $options = array();

    /**
     * Sets the connection API name (e.g. a specific CW API: 'ConfigurationItem')
     *
     * @throws ApiException
     * @param string $apiName
     * @return void
     **/
    public function setName($apiName)
    {
        if (is_string($apiName) === false)
        {
            throw new ApiException('Connection name must be a string.');
        }

        if (is_null($this->apiName) === true)
        {
            $this->apiName = $apiName;
        }
        else
        {
            if ($this->apiName != $apiName)
            {
                $this->apiName == $apiName;
            }
        }
    }

    /**
     * Get the connection API name
     *
     * @throws ApiException
     * @return string
     */
    public function getName()
    {
        if (is_null($this->apiName) === true OR strlen($this->apiName) < 1)
        {
            throw new ApiException('An API name has not been set.');
        }

        return $this->apiName;
    }

    /**
     * Sets the connection address
     *
     * @throws ApiException
     * @param string $address
     * @return void
     */
    public function setAddress($address)
    {
        if (is_string($address) === false)
        {
            throw new ApiException('Connection address must be a string.');
        }

        $this->address = $address;
    }

    /**
     * Get the connection address
     *
     * @throws ApiException
     * @return string
     */
    public function getAddress()
    {
        if (is_null($this->address) === true)
        {
            throw new ApiException('Connection address has not been set.');
        }

        return $this->address;
    }

    /**
     * Set the subdomain
     *
     * @throws ApiException
     * @param string $domain
     * @return void
     */
    public function setDomain($domain)
    {
        if (is_string($domain) === false)
        {
            throw new ApiException('Domain must be a string.');
        }

        $this->domain = $domain;
    }

    /**
     * Get the subdomain
     * 
     * @throws ApiException
     * @return string
     */
    public function getDomain()
    {
        if (is_null($this->domain) === true OR strlen($this->domain) < 1)
        {
            throw new ApiException('Domain has not been set.');
        }

        return $this->domain;
    }

    /**
     * Set some connection options (not required)
     *
     * @param array $options
     * @return void
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get connection options
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Build a full address to connect to
     *
     * @return void
     */
    public function buildFullAddress()
    {
        $this->fullAddress = sprintf($this->getAddress(), $this->getDomain(), $this->getName());
    }

    /**
     * Start connection to the CW API via SOAP
     *
     * @throws ApiException
     * @param string $apiConnectionAddy
     * @param array $connectionOptions
     * @return SoapClient
     **/
    public function start($api = null)
    {
        // Optionally pass api when starting connection
        if (is_null($api) === false)
        {
            $this->setName($api);
        }

        // Build full address
        $this->buildFullAddress();

        try
        {
            // Start SOAP connection instance
            return new SoapClient($this->fullAddress, $this->options);  
        }
        catch (Exception $error)
        {
            // Note sure if Soap Fault or...?
            throw new ApiException($error->getMessage());
        }
    }
}