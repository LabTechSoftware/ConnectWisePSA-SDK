<?php

use LabtechSoftware\ConnectwisePsaSdk\Reporting;

/**
 * Tests for \ConnectwisePsaSdk\Reporting
 * @todo Add tests for getPortalReports, runPortalReport -- Need sufficient privs to test
 *
 * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting
 */
class ReportingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Reporting instance goes here
     *
     * @var LabtechSoftware\ConnectwisePsaSdk\Reporting
     */
    protected $fixture;


    /**
     * Set a new instance of Reporting as the fixture
     */
    protected function setUp()
    {
        $client = $this->getMockBuilder('LabtechSoftware\ConnectwisePsaSdk\ConnectWiseApi')
            ->disableOriginalConstructor()
            ->getMock();

        $this->fixture = new Reporting($client);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting::getReportFields
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetReportFieldsThrowsExceptionWhenReportNameIsNotAString()
    {
        $this->fixture->getReportFields(3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting::getReports
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetReportsThrowsExceptionWhenIncludeFieldsIsNotBoolean()
    {
        $this->fixture->getReports('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting::runReportCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRunReportCountThrowsExceptionWhenReportNameIsNotAString()
    {
        $this->fixture->runReportCount(3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting::runReportCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRunReportCountThrowsExceptionWhenConditionsIsNotAString()
    {
        $this->fixture->runReportCount('', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting::runReportQuery
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRunReportQueryThrowsExceptionWhenReportNameIsNotAString()
    {
        $this->fixture->runReportQuery(3, 3, 3, '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting::runReportQuery
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRunReportQueryThrowsExceptionWhenLimitIsNotNumeric()
    {
        $this->fixture->runReportQuery('', '', 3, '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting::runReportQuery
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRunReportQueryThrowsExceptionWhenSkipIsNotNumeric()
    {
        $this->fixture->runReportQuery('', 3, '', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting::runReportQuery
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRunReportQueryThrowsExceptionWhenConditionsIsNotAString()
    {
        $this->fixture->runReportQuery('', 3, 3, 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Reporting::runReportQuery
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRunReportQueryThrowsExceptionWhenOrderByIsNotAString()
    {
        $this->fixture->runReportQuery('', 3, 3, '', 3);
    }
}
