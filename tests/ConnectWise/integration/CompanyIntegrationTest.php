<?php

use LabtechSoftware\ConnectwisePsaSdk\ApiException;
use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory;

class CompanyIntegrationTests extends PHPUnit_Framework_TestCase
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
        $this->fixture = $factory->make('Company', $configArray);
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
