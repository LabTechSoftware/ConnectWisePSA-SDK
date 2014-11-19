<?php

use LabtechSoftware\ConnectwisePsaSdk\ApiException;
use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory;

class ConfigurationIntegrationTest extends PsaTestCase
{
    protected $fixture;

    protected function setUp()
    {
        $configArray = parent::setUp();

        $factory = new ConnectwiseApiFactory();
        $this->fixture = $factory->make('Configuration', $configArray);
    }

    /**
     * Creates a new configuration type with questions and possible answers.
     */
    public function testAddOrUpdateConfigurationType()
    {
        // uses time() to ensure that the Configuration Type is unique.
        $configurationTypeData = array(
            'Id' => 0,
            'InactiveFlag' => false,
            'SystemFlag' => false,
            'Name' => 'MyConfigurationType' . time(),
            'ConfigurationTypeQuestions' => array(
                'ConfigurationTypeQuestion' => array(
                    'Id' => 0,
                    'Question' => 'Question',
                    'SequenceNumber' => '1.00',
                    'FieldType' => 'Text', // or 'Number'
                    'EntryType' => 'List', // and 'EntryField', but then it is not possible to add any PossibleResponse
                    'ConfigurationTypeId' => 0,
                    'RequiredFlag' => false,
                    'InactiveFlag' => false,
                    'PossibleResponses' => array(
                        'PossibleResponse' => array(
                            array('Id' => 0, 'Value' => 'PossibleResponse1', 'DefaultFlag' => true, 'ConfigurationTypeQuestionId' => 0),
                            array('Id' => 0, 'Value' => 'PossibleResponse1', 'DefaultFlag' => true, 'ConfigurationTypeQuestionId' => 0)
                        )
                    )
                )
            )
        );
        $response = $this->fixture->addOrUpdateConfigurationType($configurationTypeData);
        $this->assertInternalType('object', $response);
        $ids = array(
            'ConfigurationTypeId' => $response->AddOrUpdateConfigurationTypeResult->Id,
            'QuestionId' => $response->AddOrUpdateConfigurationTypeResult->ConfigurationTypeQuestions->ConfigurationTypeQuestion->Id,
            'PossibleResponseId' => $response->AddOrUpdateConfigurationTypeResult->ConfigurationTypeQuestions->ConfigurationTypeQuestion->PossibleResponses->PossibleResponse[0]->Id
        );
        return $ids;
    }

    /**
     * @depends testAddOrUpdateConfigurationType
     */
    public function testAddOrUpdateConfiguration($configurationTypeData)
    {
        $configurationData = array(
            'Id' => 0,
            'ConfigurationTypeId' => $configurationTypeData['ConfigurationTypeId'],
            'ConfigurationName' => 'ConfigurationName',
            'CompanyId' => 1
        );
        $response = $this->fixture->addOrUpdateConfiguration($configurationData);
        $this->assertInternalType('object', $response);
        return $response->AddOrUpdateConfigurationResult->Id;
    }

    /**
     * @depends testAddOrUpdateConfiguration
     */
    public function testGetConfiguration($configurationId)
    {
        $response = $this->fixture->getConfiguration($configurationId);
        $this->assertInternalType('object', $response);
    }

    public function testFindConfigurations()
    {
        $response = $this->fixture->findConfigurations(1, 0, '', '');
        $this->assertInternalType('object', $response);
    }

    public function testFindConfigurationsCount()
    {
        $response = $this->fixture->findConfigurationsCount(true, '');
        $this->assertInternalType('object', $response);
    }

    /**
     * @depends testAddOrUpdateConfiguration
     */
    public function testDeleteConfiguration($configurationId)
    {
        $response = $this->fixture->deleteConfiguration($configurationId);
        $this->assertInternalType('object', $response);
    }

    /**
     * @depends testAddOrUpdateConfigurationType
     */
    public function testFindConfigurationTypes($configurationTypeData)
    {
        $response = $this->fixture->findConfigurationTypes($configurationTypeData['ConfigurationTypeId'], 0, '');
        $this->assertInternalType('object', $response);
    }

    /**
     * @depends testAddOrUpdateConfigurationType
     */
    public function testGetConfigurationType($configurationTypeData)
    {
        $response = $this->fixture->getConfigurationType($configurationTypeData['ConfigurationTypeId']);
        $this->assertInternalType('object', $response);
    }

    /**
     * @depends testAddOrUpdateConfigurationType
     */
    public function testDeletePossibleResponse($configurationTypeData)
    {
        $response = $this->fixture->deletePossibleResponse($configurationTypeData['PossibleResponseId']);
        $this->assertInternalType('object', $response);
    }

    /**
     * @depends testAddOrUpdateConfigurationType
     */
    public function testDeleteConfigurationTypeQuestion($configurationTypeData)
    {
        $response = $this->fixture->deleteConfigurationTypeQuestion($configurationTypeData['QuestionId']);
        $this->assertInternalType('object', $response);
    }

    /**
     * @depends testAddOrUpdateConfigurationType
     */
    public function testDeleteConfigurationType($configurationTypeData)
    {
        $response = $this->fixture->deleteConfigurationType($configurationTypeData['ConfigurationTypeId']);
        $this->assertInternalType('object', $response);
    }

}

