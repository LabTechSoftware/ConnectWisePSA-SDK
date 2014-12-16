<?php namespace LabtechSoftware\ConnectwisePsaSdk;

class ConfigurationIntegrationTest extends PsaTestCase
{
    protected $configuration;
    protected $factory;
    protected $fixture;

    protected function setUp()
    {
        $this->configuration = parent::setUp();
        $this->factory = new ConnectwiseApiFactory();
        $this->fixture = $this->factory->make(
            'Configuration',
            $this->configuration
        );
    }

    public function testAddConfigurationType()
    {
        $data = [
            'Id' => 0,
            'InactiveFlag' => false,
            'SystemFlag' => false,
            'Name' => 'IntegrationTestType' . time(),
            'ConfigurationTypeQuestions' => [
                'ConfigurationTypeQuestion' => [
                    'Id' => 0,
                    'Question' => 'Question',
                    'SequenceNumber' => '1.00',
                    'FieldType' => 'Text',
                    // or 'Number'
                    'EntryType' => 'List',
                    // or 'EntryField' (with no PossibleResponse!)
                    'ConfigurationTypeId' => 0,
                    'RequiredFlag' => false,
                    'InactiveFlag' => false,
                    'PossibleResponses' => [
                        'PossibleResponse' => [
                            [
                                'Id' => 0,
                                'Value' => 'PossibleResponse1',
                                'DefaultFlag' => false,
                                'ConfigurationTypeQuestionId' => 0
                            ],
                            [
                                'Id' => 0,
                                'Value' => 'PossibleResponse2',
                                'DefaultFlag' => true,
                                'ConfigurationTypeQuestionId' => 0
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $results = $this->fixture->addOrUpdateConfigurationType($data);
        $this->assertInternalType('object', $results);
        $results = $results->AddOrUpdateConfigurationTypeResult;
        $this->assertConfigurationTypeStructure($data, $results);

        return [
            'CT_ID' => $results->Id,
            'CQ_ID' => $results->ConfigurationTypeQuestions->ConfigurationTypeQuestion->Id,
            'PR_ID' => $results->ConfigurationTypeQuestions->ConfigurationTypeQuestion->PossibleResponses->PossibleResponse[0]->Id,
            'PR_ID2' => $results->ConfigurationTypeQuestions->ConfigurationTypeQuestion->PossibleResponses->PossibleResponse[1]->Id
        ];
    }

    /**
     * @depends testAddConfigurationType
     * @param $res
     */
    public function testUpdateConfigurationType($res)
    {
        $data = [
            'Id' => $res['CT_ID'],
            'InactiveFlag' => false,
            'SystemFlag' => false,
            'Name' => 'IntegrationTestType' . time(),
            'ConfigurationTypeQuestions' => [
                'ConfigurationTypeQuestion' => [
                    'Id' => $res['CQ_ID'],
                    'Question' => 'Question',
                    'SequenceNumber' => '1.00',
                    'FieldType' => 'Text',
                    // or 'Number'
                    'EntryType' => 'List',
                    // or 'EntryField' (with no PossibleResponse!)
                    'ConfigurationTypeId' => $res['CT_ID'],
                    'RequiredFlag' => false,
                    'InactiveFlag' => false,
                    'PossibleResponses' => [
                        'PossibleResponse' => [
                            [
                                'Id' => $res['PR_ID'],
                                'Value' => 'PossibleResponse1',
                                'DefaultFlag' => false,
                                'ConfigurationTypeQuestionId' => $res['CQ_ID']
                            ],
                            [
                                'Id' => $res['PR_ID2'],
                                'Value' => 'PossibleResponse2',
                                'DefaultFlag' => true,
                                'ConfigurationTypeQuestionId' => $res['CQ_ID']
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $results = $this->fixture->addOrUpdateConfigurationType($data);
        $this->assertInternalType('object', $results);
        $results = $results->AddOrUpdateConfigurationTypeResult;
        $this->assertConfigurationTypeStructure($data, $results);

        $res['Data'] = $data;
        return $res;
    }

    /**
     * @depends testUpdateConfigurationType
     * @param $res
     */
    public function testGetConfigurationType($res)
    {
        $data = $res['Data'];
        $results = $this->fixture->getConfigurationType($res['CT_ID']);
        $this->assertInternalType('object', $results);
        $results = $results->GetConfigurationTypeResult;
        $this->assertConfigurationTypeStructure($data, $results);
    }

    /**
     * @depends testAddConfigurationType
     * @param $res
     */
    public function testAddConfiguration($res)
    {
        $data = [
            'Id' => 0,
            'ConfigurationTypeId' => $res['CT_ID'],
            'ConfigurationName' => 'Integration Configuration',
            'CompanyId' => 1
        ];

        $results = $this->fixture->addOrUpdateConfiguration($data);
        $this->assertInternalType('object', $results);
        $results = $results->AddOrUpdateConfigurationResult;
        $this->assertConfigurationStructure($data, $results);

        $res['ConfigID'] = $results->Id;
        return $res;
    }

    /**
     * @depends testAddConfiguration
     * @param $res
     */
    public function testUpdateConfiguration($res)
    {
        $data = [
            'Id' => $res['ConfigID'],
            'ConfigurationTypeId' => $res['CT_ID'],
            'ConfigurationName' => 'Integration Config',
            'CompanyId' => 1
        ];

        $results = $this->fixture->addOrUpdateConfiguration($data);
        $this->assertInternalType('object', $results);
        $results = $results->AddOrUpdateConfigurationResult;
        $this->assertConfigurationStructure($data, $results);

        $res['Data'] = $data;
        return $res;
    }

    /**
     * @depends testUpdateConfiguration
     * @param $res
     */
    public function testGetConfiguration($res)
    {
        $results = $this->fixture->getConfiguration($res['ConfigID']);
        $this->assertInternalType('object', $results);
        $results = $results->GetConfigurationResult;
        $this->assertConfigurationStructure($res['Data'], $results);
    }

    /**
     * @dataProvider singleVsMultipleCheckDataProvider
     * @param $count
     */
    public function testFindConfigurations($count)
    {
        $results = $this->fixture->findConfigurations($count, 0, '', '');

        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->FindConfigurationsResult);
        if ($count === 1) {
            $this->assertConfigurationFindStructure($results->FindConfigurationsResult->ConfigurationFindResult);
        } else {
            $this->assertInternalType('array', $results->FindConfigurationsResult->ConfigurationFindResult);
            foreach ($results->FindConfigurationsResult->ConfigurationFindResult as $item) {
                $this->assertConfigurationFindStructure($item);
            }
        }
    }

    public function testFindConfigurationsCount()
    {
        $results = $this->fixture->findConfigurationsCount(true, '');
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->FindConfigurationsCountResult);
    }

    /**
     * @dataProvider singleVsMultipleCheckDataProvider
     */
    public function testFindConfigurationTypes($count)
    {
        $results = $this->fixture->findConfigurationTypes($count, 0, '', '');
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->FindConfigurationTypesResult);
        if ($count === 1) {
            $this->assertInternalType('object', $results->FindConfigurationTypesResult->ConfigurationTypeFindResult);
            $items = [$results->FindConfigurationTypesResult->ConfigurationTypeFindResult];
        } else {
            $this->assertInternalType('array', $results->FindConfigurationTypesResult->ConfigurationTypeFindResult);
            $items = $results->FindConfigurationTypesResult->ConfigurationTypeFindResult;
        }

        foreach ($items as $item) {
            $this->assertInternalType('object', $item);
            $this->assertInternalType('integer', $item->Id);
            $this->assertInternalType('string', $item->Name);
            $this->assertInternalType('boolean', $item->InactiveFlag);
            $this->assertInternalType('boolean', $item->SystemFlag);
        }
    }

    /**
     * @depends testAddConfigurationType
     * @param $res
     */
    public function testDeletePossibleResponse($res)
    {
        $results = $this->fixture->deletePossibleResponse($res['PR_ID']);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @depends testAddConfigurationType
     * @param $res
     */
    public function testDeleteConfigurationTypeQuestion($res)
    {
        $results = $this->fixture->deleteConfigurationTypeQuestion($res['CQ_ID']);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @depends testAddConfiguration
     * @param $res
     */
    public function testDeleteConfiguration($res)
    {
        $results = $this->fixture->deleteConfiguration($res['ConfigID']);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @depends testAddConfigurationType
     * @param $res
     */
    public function testDeleteConfigurationType($res)
    {
        $results = $this->fixture->deleteConfigurationType($res['CT_ID']);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @param $data
     * @param $result
     */
    private function assertConfigurationStructure($data, $results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->Id);
        $this->assertInternalType('integer', $results->ConfigurationTypeId);
        $this->assertInternalType('integer', $results->StatusId);
        $this->assertInternalType('string', $results->Status);
        $this->assertSame($data['ConfigurationName'], $results->ConfigurationName);
        $this->assertSame($data['CompanyId'], $results->CompanyId);
        $this->assertInternalType('integer', $results->ContactId);
        $this->assertInternalType('integer', $results->OwnerLevelId);
        $this->assertInternalType('integer', $results->BillingUnitId);
        $this->assertInternalType('string', $results->Manufacturer);
        $this->assertInternalType('integer', $results->ManufacturerId);
        $this->assertInternalType('string', $results->SerialNumber);
        $this->assertInternalType('string', $results->ModelNumber);
        $this->assertInternalType('string', $results->TagNumber);
        $this->assertNotFalse(strtotime($results->PurchaseDate));
        $this->assertNotFalse(strtotime($results->InstallationDate));
        $this->assertInternalType('string', $results->InstalledBy);
        $this->assertNotFalse(strtotime($results->WarrantyExpiration));
        $this->assertNotFalse(strtotime($results->LastUpdate));
        $this->assertInternalType('string', $results->UpdatedBy);
        $this->assertNull($results->AddressId);
        $this->assertInternalType('string', $results->VendorNotes);
        $this->assertInternalType('string', $results->Notes);
        $this->assertInternalType('string', $results->MacAddress);
        $this->assertInternalType('string', $results->LastLoginName);
        $this->assertInternalType('boolean', $results->BillFlag);
        $this->assertInternalType('integer', $results->BackupSuccesses);
        $this->assertInternalType('integer', $results->BackupIncomplete);
        $this->assertInternalType('integer', $results->BackupFailed);
        $this->assertInternalType('integer', $results->BackupRestores);
        $this->assertNotFalse(strtotime($results->LastBackupDate));
        $this->assertInternalType('string', $results->BackupServerName);
        $this->assertInternalType('string', $results->BackupBillableSpaceGb);
        $this->assertInternalType('string', $results->BackupProtectedDeviceList);
        $this->assertInternalType('integer', $results->BackupYear);
        $this->assertInternalType('integer', $results->BackupMonth);
        $this->assertInternalType('string', $results->IPAddress);
        $this->assertInternalType('string', $results->DefaultGateway);
        $this->assertInternalType('string', $results->OSType);
        $this->assertInternalType('string', $results->OSInfo);
        $this->assertInternalType('string', $results->CPUSpeed);
        $this->assertInternalType('string', $results->RAM);
        $this->assertInternalType('string', $results->LocalHardDrives);
        $this->assertInternalType('boolean', $results->IsActive);
        $this->assertNull($results->ParentConfigurationID);
        $this->assertInternalType('object', $results->ConfigurationQuestions);
        $this->assertInternalType('object', $results->VendorCompany);
        $this->assertInternalType('integer', $results->VendorCompany->Id);
        $this->assertInternalType('string', $results->VendorCompany->Name);
        $this->assertInternalType('object', $results->ManufacturerCompany);
        $this->assertInternalType('integer', $results->ManufacturerCompany->Id);
        $this->assertInternalType('string', $results->ManufacturerCompany->Name);
    }

    /**
     * @param $data
     * @param $result
     */
    private function assertConfigurationTypeStructure($data, $results)
    {
        $dataQuestions = $data['ConfigurationTypeQuestions'];
        $dataResponses = $dataQuestions['ConfigurationTypeQuestion']['PossibleResponses'];

        $questions = $results->ConfigurationTypeQuestions;
        $responses = $questions->ConfigurationTypeQuestion->PossibleResponses;

        // Type Assertions
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->Id);
        $this->assertInternalType('string', $results->UpdatedBy);

        $this->assertInternalType('object', $questions);
        $this->assertInternalType('object', $questions->ConfigurationTypeQuestion);
        $this->assertInternalType('integer', $questions->ConfigurationTypeQuestion->Id);
        $this->assertInternalType('integer', $questions->ConfigurationTypeQuestion->ConfigurationTypeId);
        $this->assertInternalType('integer', $questions->ConfigurationTypeQuestion->NumberOfDecimals);

        $this->assertInternalType('object', $responses);
        $this->assertInternalType('array', $responses->PossibleResponse);
        $this->assertInternalType('object', $responses->PossibleResponse[0]);
        $this->assertInternalType('object', $responses->PossibleResponse[1]);
        $this->assertInternalType('integer', $responses->PossibleResponse[0]->Id);
        $this->assertInternalType('integer', $responses->PossibleResponse[1]->Id);
        $this->assertInternalType('integer', $responses->PossibleResponse[0]->ConfigurationTypeQuestionId);
        $this->assertInternalType('integer', $responses->PossibleResponse[1]->ConfigurationTypeQuestionId);

        // Value Assertions
        $this->assertSame($data['Name'], $results->Name);
        $this->assertSame($data['InactiveFlag'], $results->InactiveFlag);
        $this->assertSame($data['SystemFlag'], $results->SystemFlag);

        $this->assertSame(
            $dataQuestions['ConfigurationTypeQuestion']['FieldType'],
            $questions->ConfigurationTypeQuestion->FieldType
        );
        $this->assertSame(
            $dataQuestions['ConfigurationTypeQuestion']['EntryType'],
            $questions->ConfigurationTypeQuestion->EntryType
        );
        $this->assertSame(
            $dataQuestions['ConfigurationTypeQuestion']['SequenceNumber'],
            $questions->ConfigurationTypeQuestion->SequenceNumber
        );
        $this->assertSame(
            $dataQuestions['ConfigurationTypeQuestion']['Question'],
            $questions->ConfigurationTypeQuestion->Question
        );
        $this->assertSame(
            $dataQuestions['ConfigurationTypeQuestion']['RequiredFlag'],
            $questions->ConfigurationTypeQuestion->RequiredFlag
        );
        $this->assertSame(
            $dataQuestions['ConfigurationTypeQuestion']['InactiveFlag'],
            $questions->ConfigurationTypeQuestion->InactiveFlag
        );

        $this->assertSame($dataResponses['PossibleResponse'][0]['Value'], $responses->PossibleResponse[0]->Value);
        $this->assertSame($dataResponses['PossibleResponse'][1]['Value'], $responses->PossibleResponse[1]->Value);
        $this->assertSame(
            $dataResponses['PossibleResponse'][0]['DefaultFlag'],
            $responses->PossibleResponse[0]->DefaultFlag
        );
        $this->assertSame(
            $dataResponses['PossibleResponse'][1]['DefaultFlag'],
            $responses->PossibleResponse[1]->DefaultFlag
        );
    }

    private function assertConfigurationFindStructure($item)
    {
        $this->assertInternalType('integer', $item->Id);
        $this->assertInternalType('integer', $item->ConfigurationTypeId);
        $this->assertInternalType('string', $item->ConfigurationType);
        $this->assertInternalType('integer', $item->StatusId);
        $this->assertInternalType('string', $item->Status);
        $this->assertInternalType('string', $item->CompanyId);
        $this->assertInternalType('string', $item->ConfigurationName);
        $this->assertInternalType('string', $item->ContactName);
        $this->assertInternalType('string', $item->SerialNumber);
        $this->assertInternalType('string', $item->ModelNumber);
        $this->assertInternalType('string', $item->TagNumber);
        if ($item->WarrantyExpiration !== null) {
            $this->assertNotFalse(strtotime($item->WarrantyExpiration));
        }
    }

    /**
     * @return array
     */
    public static function singleVsMultipleCheckDataProvider()
    {
        return [
            [1],
            [2],
            [5]
        ];
    }
}
