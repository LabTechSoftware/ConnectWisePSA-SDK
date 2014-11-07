<?php

use LabtechSoftware\ConnectwisePsaSdk\ApiException;
use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory;

class ReportingIntegrationTest extends PHPUnit_Framework_TestCase
{
    protected $fixture;

    protected function setUp()
    {
        $configArray = include 'src/LabtechSoftware/ConnectwisePsaSdk/config/config.php';

        if (getenv('SOAP_VERSION')) {
            $configArray['soap']['soap_version'] = trim(getenv('SOAP_VERSION'));
        }

        if (getenv('EXCEPTIONS')) {
            $configArray['soap']['exceptions'] = trim(getenv('EXCEPTIONS'));
        }

        if (getenv('TRACE')) {
            $configArray['soap']['trace'] = trim(getenv('TRACE'));
        }

        if (getenv('CACHE_WSDL')) {
            $configArray['soap']['cache_wsdl'] = trim(getenv('CACHE_WSDL'));
        }

        if (getenv('CW_API_MAIN')) {
            $configArray['url']['cw_api_main'] = trim(getenv('CW_API_MAIN'));
        }

        if (getenv('DOMAIN')) {
            $configArray['credentials']['domain'] = trim(getenv('DOMAIN'));
        } else {
            throw new ApIException('DOMAIN must be set in environment');
        }

        if (getenv('COMPANYID')) {
            $configArray['credentials']['CompanyId'] = trim(getenv('COMPANYID'));
        } else {
            throw new ApIException('COMPANYID must be set in environment');
        }

        if (getenv('INTEGRATORLOGINID')) {
            $configArray['credentials']['IntegratorLoginId'] = trim(getenv('INTEGRATORLOGINID'));
        } else {
            throw new ApIException('INTEGRATORLOGINID must be set in environment');
        }

        if (getenv('INTEGRATORPASSWORD')) {
            $configArray['credentials']['IntegratorPassword'] = trim(getenv('INTEGRATORPASSWORD'));
        } else {
            throw new ApIException('INTEGRATORPASSWORD must be set in environment');
        }


        $factory = new ConnectwiseApiFactory();
        $this->fixture = $factory->make('Reporting', $configArray);
    }

    public function testGetReports()
    {
        $response = $this->fixture->getReports(false);
        $this->assertInternalType('object', $response);
    }

    public function testGetReportFields()
    {
        $response = $this->fixture->getReportFields("Service");
        $this->assertInternalType('object', $response);
    }

    public function testRunReportCount()
    {
        $response = $this->fixture->runReportCount("Service");
        $this->assertInternalType('object', $response);
    }

    public function testRunReportQuery()
    {
        $response = $this->fixture->runReportQuery("Service", 3, 0, '', '');
        $this->assertInternalType('object', $response);
    }

    public function testRunReportQueryWithFilters()
    {
        $response = $this->fixture->runReportQueryWithFilters("Service", 3, 0, '', '', array('Last_Update'));
        $this->assertInternalType('object', $response);
    }
}
