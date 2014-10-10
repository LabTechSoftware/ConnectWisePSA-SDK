<?php

namespace LabtechSoftware\ConnectwisePsaSdk;

use SoapClient;

class ConnectwiseApiFactory
{
    private $config = '';

    public function __construct($customConfig = '')
    {
        if (is_array($customConfig) === false && strlen($customConfig) < 1) {
            $this->config = __DIR__ . '/config/config.ini';
        } else {
            $this->config = $customConfig;
        }


    }

    public function makeContact()
    {
        return new Contact($this->wireDependencies('ContactAPI'));
    }

    public function makeCompany()
    {
        return new Company($this->wireDependencies('CompanyAPI'));
    }

    public function makeConfiguration()
    {
        return new Configuration($this->wireDependencies('ConfigurationAPI'));
    }

    public function makeReporting()
    {
        return new Reporting($this->wireDependencies('ReportingAPI'));
    }

    public function makeServiceTicket()
    {
        return new ServiceTicket($this->wireDependencies('ServiceTicketApi'));
    }

    private function wireDependencies($apiName)
    {
        $cl = new ConfigLoader();

        $cl->loadConfig($this->config);

        $soap = new SoapClient($cl->getSoapAddress($apiName), $cl->getSoapOptions());

        return new SoapApiRequester($soap, $cl);
    }
}
