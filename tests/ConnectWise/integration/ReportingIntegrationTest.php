<?php

use LabtechSoftware\ConnectwisePsaSdk\ApiException;
use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory;

class ReportingIntegrationTest extends PsaTestCase
{
    protected $fixture;

    protected function setUp()
    {
        $configArray = parent::setUp();

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
        $this->assertInternalType('array', $response);
    }

    public function testRunReportQueryWithFilters()
    {
        $response = $this->fixture->runReportQueryWithFilters("Service", 3, 0, '', '', array('Last_Update'));
        $this->assertInternalType('object', $response);
    }
}
