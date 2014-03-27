<?php

namespace LabtechSoftware\ConnectwisePsaSdk;

use SoapClient;

class ConnectwiseApiFactory
{
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

        $cl->loadConfig();

        $soap = new SoapClient($cl->getSoapAddress($apiName), $cl->getSoapOptions());

        return new SoapApiRequester($soap, $cl);
    }
}
