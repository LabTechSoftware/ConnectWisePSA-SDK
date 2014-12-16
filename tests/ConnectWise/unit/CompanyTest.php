<?php

use LabtechSoftware\ConnectwisePsaSdk\Company;

class CompanyTest extends PHPUnit_Framework_TestCase
{
    protected $fixture;


    protected function setup()
    {
        $client = $this->getMockBuilder('LabtechSoftware\ConnectwisePsaSdk\ConnectWiseApi')
            ->disableOriginalConstructor()
            ->getMock();

        $this->fixture = new Company($client);
    }


    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Company::addOrUpdateCompany
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testPassEmptyArrayToAddOrUpdateCompany()
    {
        $this->fixture->addOrUpdateCompany(array());
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Company::getCompany
     * @expectedException LabTechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testPassStringToGetCompany()
    {
        $this->fixture->getCompany('hello');
    }


    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Company::getCompany
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testPassZeroToGetCompany()
    {
        $this->fixture->getCompany(0);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Company::deleteCompany
     * @expectedException LabtechSoftware\ConnectWisePsaSdk\ApiException
     */
    public function testPassStringToDeleteCompany()
    {
        $this->fixture->deleteCompany('a string');
    }


    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Company::findCompanies
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindCompaniesThrowsExceptionWhenLimitIsNotNumeric()
    {
        $this->fixture->findCompanies('', 0, '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Company::findCompanies
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindCompaniesThrowsExceptionWhenSkipIsNotNumeric()
    {
        $this->fixture->findCompanies(0, '', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Company::findCompanies
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindCompaniesThrowsExceptionWhenOrderByIsNotString()
    {
        $this->fixture->findCompanies(0, 0, 0, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Company::findCompanies
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindCompaniesThrowsExceptionWhenConditionsIsNotString()
    {
        $this->fixture->findCompanies(0, 0, '', 0);
    }
}
