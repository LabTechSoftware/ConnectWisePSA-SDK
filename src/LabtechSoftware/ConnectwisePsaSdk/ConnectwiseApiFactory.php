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


/*    private $methodPrefix = 'make';
    private $methodToCall = '';

    public function __call($methodName, $args)
    {
        $this->setMethodName($methodName);

        if (method_exists($this, $this->methodToCall) === false) {
            throw new Exception('Unknown Method.');
        }

        return $this->runMethod($this->methodToCall, $args);
    }

    private function runMethod($class, $args)
    {
        return call_user_func_array(array($this, $class), $args);
    }

    private function setMethodName($method)
    {
        $this->methodToCall = $this->methodPrefix . ucfirst($method);
    }*/

}
