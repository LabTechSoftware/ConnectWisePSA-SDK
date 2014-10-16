<?php

namespace LabtechSoftware\ConnectwisePsaSdk;

use SoapClient;

class ConnectwiseApiFactory
{
    private $config = '';

    public function __construct()
    {
        $this->config = __DIR__ . '/config/config.ini';
    }

    public function make($api, $config = '')
    {
        $this->setConfig($config);

        switch ($api) {
            case 'Contact':
                return new Contact($this->wireDependencies('ContactAPI'));
            case 'Company':
                return new Company($this->wireDependencies('CompanyAPI'));
            case 'Configuration':
                return new Configuration($this->wireDependencies('ConfigurationAPI'));
            case 'Document':
                return new Document($this->wireDependencies('DocumentAPI'));
            case 'Reporting':
                return new Reporting($this->wireDependencies('ReportingAPI'));
            case 'ServiceTicket':
                return new ServiceTicket($this->wireDependencies('ServiceTicketAPI'));
            default:
                throw new ApiException('API not available in SDK');
        }
    }

    private function setConfig($config)
    {
        // if empty don't do anything
        if ($config) {

            // config must be a string (path to file)
            if (!is_string($config)) {
                throw new ApiException('Config must be a string');
            }

            // config file must exist
            if (!file_exists($config)) {
                throw new ApiException('Config does not exist');
            }

            $this->config = $config;
        }
    }

    private function wireDependencies($apiName)
    {
        $cl = new ConfigLoader();

        $cl->loadConfig($this->config);

        $soap = new SoapClient($cl->getSoapAddress($apiName), $cl->getSoapOptions());

        return new SoapApiRequester($soap, $cl);
    }
}
