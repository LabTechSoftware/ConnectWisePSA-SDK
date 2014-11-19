<?php

use LabtechSoftware\ConnectwisePsaSdk\ApiException;
use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory;

class CompanyIntegrationTests extends PsaTestCase
{
    protected $configArray;
    protected $factory;
    protected $fixture;

    protected function setUp()
    {
        $this->configArray = parent::setUp();
        $this->factory = new ConnectwiseApiFactory();
        $this->fixture = $this->factory->make('Company', $this->configArray);
    }

    public function testAddCompany()
    {
        // when we delete a company from the PSA, the record is still stored
        // in the DB and when we rerun our tests, we will get an error stating
        // that the company ID is not unique, use time() to make sure each time
        // we run tests we have a unique company ID.
        $params = [
            'DefaultAddress' => [
                'Id' => 0,
                'DefaultFlag' => true,
                'CompanyRecid' => 0,
                'SiteName' => 'American Headquarters'
            ],
            'CompanyName' => 'Pandora IncInc.',
            'CompanyID' => 'Pandora' . time(),
            'PhoneNumber' => '8135555555',
            'FaxNumber' => '8135551111',
            'WebSite' => 'http://pandora.com',
            'Id' => 0
        ];

        $company = $this->fixture->addOrUpdateCompany($params);

        $this->assertInternalType('object', $company);

        $compData = [
            'Id' => $company->AddOrUpdateCompanyResult->Id,
            'CompanyId' => $params['CompanyID']
        ];

        return $compData;
    }

    /**
     * @depends testAddCompany
     */
    public function testUpdateCompany($compData)
    {
        $params = [
            'DefaultAddress' => [
                'Id' => 0,
                'DefaultFlag' => true,
                'CompanyRecid' => 0,
                'SiteName' => 'American Headquarters'
            ],
            'CompanyName' => 'Pandora IncSUP.',
            'CompanyID' => $compData['CompanyId'],
            'PhoneNumber' => '8131111111',
            'FaxNumber' => '8135551111',
            'WebSite' => 'http://pandora.com',
            'Id' => $compData['Id']
        ];

        $company = $this->fixture->addOrUpdateCompany($params);

        $this->assertInternalType('object', $company);
    }

    /**
     * @depends testAddCompany
     */
    public function testGetCompany($compData)
    {
        $company = $this->fixture->getCompany($compData['Id']);
        $this->assertInternalType('object', $company);
        return $company->GetCompanyResult->Id;
    }

    /**
     * @depends testAddCompany
     */
    public function testFindCompany($compData)
    {
        $this->assertInternalType(
            'object',
            $this->fixture->findCompanies(1, 0, '', "CompanyRecid = {$compData['Id']}")
        );
    }

    /**
     * @depends testAddCompany
     */
    public function testDeleteCompany($compData)
    {
        $this->assertInternalType('object', $this->fixture->deleteCompany($compData['Id']));
    }
}