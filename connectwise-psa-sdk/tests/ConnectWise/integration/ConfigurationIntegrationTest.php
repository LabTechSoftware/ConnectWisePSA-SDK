<?php

use LabtechSoftware\ConnectwisePsaSdk\SoapApiRequester;
use LabtechSoftware\ConnectwisePsaSdk\Configuration;

class ConfigurationIntegrationTest extends PHPUnit_Framework_TestCase
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
            'http://test.connectwise.com/v4_6_release/apis/1.5/ConfigurationAPI.asmx?wsdl',
            array(
                'soap_version' => SOAP_1_1,
                'exception' => true,
                'trace' => 1,
                'cache_wsdl' => WSDL_CACHE_NONE
            )
        );

        $client = new SoapApiRequester($soap, $configLoader);

        $this->fixture = new Configuration($client);
    }

    /**
     * Creates a new configuration type with questions and possible answers.
     */
    public function testAddOrUpdateConfigurationType()
    {
        $configurationTypeData = array(
            'Id' => 0,
            'InactiveFlag' => false,
            'SystemFlag' => false,
            'Name' => 'MyConfigurationType000',
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

