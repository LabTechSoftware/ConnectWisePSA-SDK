<?php namespace LabtechSoftware\ConnectwisePsaSdk\ConnectionTypes;

use SoapFault,
    SoapClient,
    LabtechSoftware\ConnectwisePsaSdk\Support\ApiException,
    LabtechSoftware\ConnectwisePsaSdk\Support\Contracts\ConnectionInterface;

/**
 * ConnectWise SOAP Request Handler
 * 
 * @package ConnectwisePsaSdk
 */
class Soap implements ConnectionInterface
{
    /**
     * SOAP Client
     *
     * @var SoapClient
     */
    private $soap;

    /**
     * Connection credentials
     *
     * @var array
     **/
    private $credentials = array();

    /**
     * Bind new instance of SoapClient and the config array
     *
     * @param SoapClient $clientInstance
     * @param array $creds
     * @return void
     */
    public function __construct(SoapClient $clientInstance, array $creds)
    {
        $this->credentials = $creds;
        $this->soap = $clientInstance;
    }

    /**
     * Make a request to the ConnectWise API
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param string $method
     * @param array $params
     * @return mixed
     */
    public function makeRequest($method, $params = array())
    {
        // Add credentials to params array
        // There might or might not be data added to params array already
        $params['credentials'] = $this->credentials;

        try {
            return $this->soap->{$method}($params);
        } catch (SoapFault $fault) {
            throw new ApiException($fault->getMessage());
        }
    }
}
