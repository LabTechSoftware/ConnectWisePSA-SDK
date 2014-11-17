<?php

use LabtechSoftware\ConnectwisePsaSdk\ApiException;
use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory;

class ConfigurationIntegrationTest extends PHPUnit_Framework_TestCase
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
        $this->fixture = $factory->make('Configuration', $configArray);
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

