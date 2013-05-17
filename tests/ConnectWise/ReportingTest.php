<?php

/**
 * Tests for \ConnectWiseApi\Reporting
 * @todo Add tests for getPortalReports, runPortalReport -- Need sufficient privs to test
 *
 * @covers ConnectWiseApi\Reporting
 */
class ReportingTest extends \PHPUnit_Framework_TestCase
{
    protected $fixture;

    protected $validReportName = 'IVCategory';
    protected $invalidReportName = 'this_report_does_not_exist_1289jsdlfk092';

    /**
     * New instance for fixture
     */
    protected function setUp()
    {
        // Set class instance
        $this->fixture = new ConnectWiseApi\Reporting;
    }

    /**
     * @covers ConnectWiseApi\Reporting
     */
    public function testCurrentApiNameExists()
    {
        $this->assertObjectHasAttribute('currentApi', $this->fixture);
    }

    /**
     * @covers ConnectWiseApi\Reporting::getReportFields
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetReportFieldsThrowsExceptionOnNonStringParam()
    {
        $this->fixture->getReportFields(1231);
    }

    /**
     * @covers ConnectWiseApi\Reporting::getReportFields
     */
    public function testGetReportFieldsReturnsEmptyArrayWhenNoArgumentsPassed()
    {
        $getResult = $this->fixture->getReportFields();

        $this->assertTrue(is_array($getResult));
        $this->assertEquals(0, count($getResult));
    }

    /**
     * @covers ConnectWiseApi\Reporting::getReportFields
     */
    public function testGetReportFieldsReturnsEmptyArrayWhenReportNotFound()
    {
        $getResult = $this->fixture->getReportFields($this->invalidReportName);

        $this->assertTrue(is_array($getResult));
        $this->assertEquals(0, count($getResult));
    }

    /**
     * @covers ConnectWiseApi\Reporting::getReportFields
     */
    public function testGetReportFieldsReturnsPopulatedArrayOnSuccess()
    {
        $getResult = $this->fixture->getReportFields($this->validReportName);

        $this->assertTrue(is_array($getResult));
        $this->assertGreaterThan(0, count($getResult));
    }

    /**
     * @covers ConnectWiseApi\Reporting::getReports
     */
    public function testGetReportsReturnsPopulatedArrayWhenNoArgumentsPassed()
    {
        $result = $this->fixture->getReports();

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectWiseApi\Reporting::getReports
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetReportsThrowsExceptionOnNonBooleanParam()
    {
        $this->fixture->getReports(1231);
    }

    /**
     * @covers ConnectWiseApi\Reporting::runReportCount
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testRunReportCountThrowsExceptionOnNonStringParams()
    {
        $this->fixture->runReportCount(1231, 09123);
    }

    /**
     * @covers ConnectWiseApi\Reporting::runReportCount
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testRunReportCountThrowsExceptionOnNonExistentReport()
    {
        $this->fixture->runReportCount($this->invalidReportName);
    }

    /**
     * @covers ConnectWiseApi\Reporting::runReportCount
     */
    public function testRunReportCountReturnsArrayWhenValidCategoryPassed()
    {
        $this->assertTrue(is_array($this->fixture->runReportCount($this->validReportName)));
    }

    /**
     * @covers ConnectWiseApi\Reporting::runReportQuery
     */
    public function testRunReportQueryReturnsArrayWhenValidCategoryPassed()
    {
        $this->assertTrue(is_array($this->fixture->runReportQuery($this->validReportName)));
    }

    /**
     * @covers ConnectWiseApi\Reporting::runReportQuery
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testRunReportQueryThrowsExceptionOnAnyWrongParamValueType()
    {
        $this->fixture->runReportQuery(11, 'should_be_integer', 'should_be_integer', 11, 11);
    }

    /**
     * @covers ConnectWiseApi\Reporting::runReportQuery
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testRunReportQueryThrowsExceptionOnNonExistentReportName()
    {
        $this->fixture->runReportQuery($this->invalidReportName);
    }
}