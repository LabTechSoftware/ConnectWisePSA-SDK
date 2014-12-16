<?php namespace LabtechSoftware\ConnectwisePsaSdk;

class CompanyIntegrationTest extends PsaTestCase
{
    protected $configuration;
    protected $factory;
    protected $fixture;

    protected function setUp()
    {
        $this->configuration = parent::setUp();
        $this->factory = new ConnectwiseApiFactory();
        $this->fixture = $this->factory->make(
            'Company',
            $this->configuration
        );
    }

    /**
     * @return array
     */
    public function testAddCompany()
    {
        $data = [
            'DefaultAddress' => [
                'Id' => 0,
                'DefaultFlag' => true,
                'InactiveFlag' => false,
                'CompanyRecid' => 0,
                'SiteName' => 'US Headquarters'
            ],
            'CompanyName' => 'Integration Test Co.',
            'CompanyID' => 'Integrate' . time(),
            'PhoneNumber' => '8135555555',
            'FaxNumber' => '8135551111',
            'WebSite' => 'http://pandora.com',
            'Id' => 0
        ];

        $results = $this->fixture->addOrUpdateCompany($data);
        $this->assertInternalType('object', $results);
        $results = $results->AddOrUpdateCompanyResult;
        $this->assertCompanyStructure($data, $results);

        return [
            'ID' => $results->Id,
            'CompanyID' => $data['CompanyID']
        ];
    }

    /**
     * @depends testAddCompany
     * @param $res
     * @return mixed
     */
    public function testUpdateCompany($res)
    {
        $data = [
            'DefaultAddress' => [
                'Id' => 0,
                'DefaultFlag' => true,
                'InactiveFlag' => false,
                'CompanyRecid' => 0,
                'SiteName' => 'US Headquarters'
            ],
            'CompanyName' => 'Integration Test Co.',
            'CompanyID' => $res['CompanyID'],
            'PhoneNumber' => rand(1000000000, 9999999999),
            'FaxNumber' => rand(1000000000, 9999999999),
            'WebSite' => 'http://integrationtest.co',
            'Id' => $res['ID']
        ];

        $results = $this->fixture->addOrUpdateCompany($data);
        $this->assertInternalType('object', $results);
        $results = $results->AddOrUpdateCompanyResult;
        $this->assertCompanyStructure($data, $results);

        $res['Data'] = $data;
        return $res;
    }

    /**
     * @depends testUpdateCompany
     * @param $res
     */
    public function testGetCompany($res)
    {
        $results = $this->fixture->getCompany($res['ID']);
        $this->assertInternalType('object', $results);
        $results = $results->GetCompanyResult;
        $this->assertCompanyStructure($res['Data'], $results);
    }

    /**
     * @depends testAddCompany
     * @param $res
     */
    public function testDeleteCompany($res)
    {
        $results = $this->fixture->deleteCompany($res['ID']);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @dataProvider limitDataProvider
     * @param $limit
     */
    public function testFindCompanies($limit)
    {
        $results = $this->fixture->findCompanies($limit, 0, '', '');
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->FindCompaniesResult);
        $results = $results->FindCompaniesResult->CompanyFindResult;
        if ($limit === 1) {
            $this->assertFindCompanyStructure($results);
        } else {
            $this->assertInternalType('array', $results);
            foreach ($results as $result) {
                $this->assertFindCompanyStructure($result);
            }
        }
    }

    /**
     * @param $data
     * @param $results
     */
    private function assertCompanyStructure($data, $results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->Addresses);
        $this->assertInternalType('object', $results->Addresses->CompanyAddress);
        $this->assertInternalType('object', $results->Addresses->CompanyAddress->StreetLines);
        $this->assertInternalType('array', $results->Addresses->CompanyAddress->StreetLines->string);
        $this->assertNull($results->Addresses->CompanyAddress->StreetLines->string[0]);
        $this->assertNull($results->Addresses->CompanyAddress->StreetLines->string[1]);
        $this->assertInternalType('string', $results->Addresses->CompanyAddress->Country);
        $this->assertInternalType('integer', $results->Addresses->CompanyAddress->Id);
        $this->assertSame($data['DefaultAddress']['DefaultFlag'], $results->Addresses->CompanyAddress->DefaultFlag);
        $this->assertInternalType('integer', $results->Addresses->CompanyAddress->CompanyRecid);
        $this->assertSame($data['DefaultAddress']['SiteName'], $results->Addresses->CompanyAddress->SiteName);
        $this->assertSame($data['DefaultAddress']['InactiveFlag'], $results->Addresses->CompanyAddress->InactiveFlag);
        $this->assertSame($data['CompanyName'], $results->CompanyName);
        $this->assertSame($data['CompanyID'], $results->CompanyID);
        $this->assertSame((string)$data['PhoneNumber'], $results->PhoneNumber);
        $this->assertSame((string)$data['FaxNumber'], $results->FaxNumber);
        $this->assertSame($data['WebSite'], $results->WebSite);
        $this->assertInternalType('integer', $results->Id);
        $this->assertInternalType('string', $results->Type);
        $this->assertInternalType('string', $results->Status);
        $this->assertInternalType('string', $results->AccountNbr);
        $this->assertInternalType('integer', $results->DefaultContactId);
        $this->assertInternalType('integer', $results->DefaultBillingContactId);
        $this->assertNotFalse(strtotime($results->LastUpdate));
    }

    private function assertFindCompanyStructure($result)
    {
        $this->assertInternalType('object', $result);
        $this->assertInternalType('integer', $result->CompanyRecID);
        $this->assertInternalType('string', $result->CompanyName);
        $this->assertInternalType('string', $result->CompanyID);
        $this->assertInternalType('string', $result->PhoneNumber);
        $this->assertInternalType('string', $result->AddressLine1);
        $this->assertInternalType('string', $result->AddressLine2);
        $this->assertInternalType('string', $result->City);
        $this->assertInternalType('string', $result->State);
        $this->assertInternalType('string', $result->Zip);
        $this->assertInternalType('string', $result->Country);
        $this->assertInternalType('string', $result->Type);
        $this->assertInternalType('string', $result->Status);
        $this->assertInternalType('string', $result->Territory);
        $this->assertInternalType('string', $result->Website);
        if (isset($result->Market)) {
            $this->assertInternalType('string', $result->Market);
        }
    }

    public function limitDataProvider()
    {
        return [
            [1],
            [2]
        ];
    }
}
