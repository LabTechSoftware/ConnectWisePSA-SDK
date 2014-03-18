<?php

use LabtechSoftware\ConnectwisePsaSdk\SoapApiRequester;
use LabtechSoftware\ConnectwisePsaSdk\Company;

class CompanyIntegrationTests extends PHPUnit_Framework_TestCase
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
            'http://test.connectwise.com/v4_6_release/apis/1.5/CompanyApi.asmx?wsdl',
            array(
                'soap_version' => SOAP_1_1,
                'exception' => true,
                'trace' => 1,
                'cache_wsdl' => WSDL_CACHE_NONE
            )
        );

        $client = new SoapApiRequester($soap, $configLoader);

        $this->fixture = new Company($client);
    }


    public function testAddCompany()
    {
        // when we delete a company from the PSA, the record is still stored in the DB
        // and when we rerun our tests, we will get an error stating that the company ID is not
        // unique, use time() to make sure each time we run tests we have a unique company ID
        $randomCompanyID = 'Pandora' . time();

        $params = array(
            'DefaultAddress' => array(
                'Id' => 0,
                'DefaultFlag' => true,
                'CompanyRecid' => 0,
                'SiteName' => 'American Headquarters'
            ),
            'CompanyName' => 'Pandora IncInc.',
            'CompanyID' => $randomCompanyID,
            'PhoneNumber' => '8135555555',
            'FaxNumber' => '8135551111',
            'WebSite' => 'http://pandora.com',
            'Id' => 0
        );

        $company = $this->fixture->addOrUpdateCompany($params);

        $this->assertInternalType('object', $company);

        $compData = array(
            'Id' => $company->AddOrUpdateCompanyResult->Id,
            'CompanyID' => $randomCompanyID
        );

        return $compData;
    }


    /**
     * @depends testAddCompany
     */
    public function testUpdateCompany($compData)
    {
        $params = array(
            'DefaultAddress' => array(
                'Id' => 0,
                'DefaultFlag' => true,
                'CompanyRecid' => 0,
                'SiteName' => 'American Headquarters'
            ),
            'CompanyName' => 'Pandora IncSUP.',
            'CompanyID' => $compData['CompanyID'],
            'PhoneNumber' => '8131111111',
            'FaxNumber' => '8135551111',
            'WebSite' => 'http://pandora.com',
            'Id' => $compData['Id']
        );


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
    public function testFindCompanies($compData)
    {
        $company_ID = $compData['Id'];

        $this->assertInternalType('object', $this->fixture->findCompanies(0, 0, '', "CompanyRecid = $company_ID"));
    }


    /**
     * @depends testAddCompany
     */
    public function testDeleteCompany($compData)
    {
        $this->assertInternalType('object', $this->fixture->deleteCompany($compData['Id']));
    }
}
