<?php

namespace LabtechSoftware\ConnectwisePsaSdk;

use SoapClient;
use SoapFault;
use LabtechSoftware\ConnectwisePsaSdk\ApiException;

class SoapApiRequester implements ConnectWiseApi
{

    private $soap;
    private $configLoader;

    public function __construct(SoapClient $soap, ConfigLoader $configLoader)
    {
        $this->soap = $soap;
        $this->configLoader= $configLoader;
    }

    public function makeRequest($method, $params = array())
    {
        // squirt credentials into params
        $params['credentials'] = $this->configLoader->getSoapCredentials();

        try {
            return $this->soap->{$method}($params);
        } catch (SoapFault $fault) {
            throw new ApiException($fault->getMessage());
        }
    }

    public function getConfigLoader()
    {
        return $this->configLoader;
    }
}
