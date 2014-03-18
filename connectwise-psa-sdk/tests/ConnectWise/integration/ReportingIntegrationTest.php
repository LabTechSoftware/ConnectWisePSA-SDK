<?php

use LabtechSoftware\ConnectwisePsaSdk\SoapApiRequester;
use LabtechSoftware\ConnectwisePsaSdk\Reporting;

class ReportingIntegrationTest extends PHPUnit_Framework_TestCase
{
    protected $fixture;

    protected function setUp()
    {
        $configLoader = $this->getMockBuilder('LabtechSoftware\ConnectwisePsaSdk\ConfigLoader')
            ->disableOriginalConstructor()
            ->getMock();

        $configLoader->expects($this->any())
            ->method('getSoapCredentials')
            ->will($this->returnValue(array(
                'CompanyId' => 'LabTech',
                'IntegratorLoginId' => 'webdev',
                'IntegratorPassword' => 'webdev'
            )));

        $soap = new SoapClient(
            'http://test.connectwise.com/v4_6_release/apis/1.5/ReportingAPI.asmx?wsdl',
            array(
                'soap_version' => SOAP_1_1,
                'exception' => true,
                'trace' => 1,
                'cache_wsdl' => WSDL_CACHE_NONE
            )
        );

        $client = new SoapApiRequester($soap, $configLoader);

        $this->fixture = new Reporting($client);
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
