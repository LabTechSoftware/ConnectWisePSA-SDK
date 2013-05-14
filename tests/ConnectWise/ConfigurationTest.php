<?php

/**
 * Tests for \ConnectWiseApi\Configuration
 *
 * @covers ConnectWiseApi\Configuration
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    protected $fixture;
    protected $randomString;

    protected $validNewConfig = array(
        'Id' => 999, 'ConfigurationTypeId' => 11, 'ConfigurationType' => 'License', 'StatusId' => 1, 
        'ConfigurationName' => '', 'CompanyId' => '99'
    );

    protected $invalidNewConfig = array(
        'ConfigurationType' => 'License', 'StatusId' => 1, 'ConfigurationName' => 'PSA Software Test 02'
    );

    protected $validNewConfigType = array(
        'Id' => 99, 'Name' => '', 'InactiveFlag' => false, 'SystemFlag' => true
    );

    protected $invalidNewConfigType = array(
        'Name' => 'Test Config Type', 'InactiveFlag' => false, 'SystemFlag' => true
    );

    protected $validUpdateConfig = array(
        'Id' => 99, 'ConfigurationTypeId' => 17, 'StatusId' => 0, 
        'ConfigurationName' => 'LT Devs Test Config Editedx1232'
    );

    protected $invalidUpdateConfig = array(
        'Id' => 0, 'ConfigurationTypeId' => 98794, 'StatusId' => 0, 
        'ConfigurationName' => 'LT Devs Test Config sxdsafsd'
    );

    protected $validUpdateConfigType = array(
        'Id' => 26, 'Name' => 'Test Config Type', 'InactiveFlag' => false, 'SystemFlag' => true,
        'ConfigurationTypeQuestions' => array('ConfigurationTypeQuestion' => array(
            'Id' => 100, 'FieldType' => 'Currency', 'EntryType' => 'Option',
            'ConfigurationTypeId' => 0, 'SequenceNumber' => 1, 'Question' => 'Wat',
            'RequiredFlag' => true, 'InactiveFlag' => false, 'PossibleResponses' => array(
                'Id' => 100, 'ConfigurationTypeQuestionId' => 100, 'Value' => 'huh', 'DefaultFlag' => false
            )
        ))
    );

    protected $invalidUpdateConfigType = array('InactiveFlag' => false, 'SystemFlag' => true);

    /**
     * New Configuration instance for fixture
     */
    protected function setUp()
    {
        $this->fixture = new ConnectWiseApi\Configuration;

        $this->randomString = 'Test Entry num' . rand(10, 1000);
    }

    /**
     * @covers ConnectWiseApi\Configuration
     */
    public function testCurrentApiNameExists()
    {
        $this->assertObjectHasAttribute('currentApi', $this->fixture);
    }

    /**
     * @covers ConnectWiseApi\Configuration::addConfiguration
     */
    public function testAddConfigurationReturnsArrayOnSuccess()
    {
        // Random config type name so we don't run into non-unique name error
        $this->validNewConfig['ConfigurationName'] = $this->randomString;

        $this->assertTrue(is_array($this->fixture->addConfiguration($this->validNewConfig)));
    }

    /**
     * @covers ConnectWiseApi\Configuration::addConfiguration
     *
     * @expectedException SoapFault
     */
    public function testAddConfigurationThrowsSoapFaultOnFail()
    {
       $this->fixture->addConfiguration($this->invalidNewConfig);
    }

    /**
     * @covers ConnectWiseApi\Configuration::addConfigurationType
     */
    public function testAddConfigurationTypeReturnsArrayOnSuccess()
    {
        // Random config type name so we don't run into non-unique name error
        $this->validNewConfigType['Name'] = $this->randomString;

        $this->assertTrue(is_array($this->fixture->addConfigurationType($this->validNewConfigType)));
    }

    /**
     * @covers ConnectWiseApi\Configuration::addConfigurationType
     *
     * @expectedException SoapFault
     */
    public function testAddConfigurationTypeThrowsSoapFaultOnFail()
    {
       $this->fixture->addConfigurationType($this->invalidNewConfigType);
    }

    /**
     * @covers ConnectWiseApi\Configuration::addOrUpdateConfiguration
     */
    public function testAddOrUpdateConfigurationReturnsArrayOnSuccess()
    {
        // Random config type name so we don't run into non-unique name error
        $this->validNewConfig['ConfigurationName'] = $this->randomString;

        // Remove Id so this is considered a new entry.
        // Change to valid Id to test pulling an existing Config
        $this->validNewConfig['Id'] = '';

        $this->assertTrue(is_array($this->fixture->addOrUpdateConfiguration($this->validNewConfig)));
    }

    /**
     * @covers ConnectWiseApi\Configuration::addOrUpdateConfiguration
     *
     * @expectedException SoapFault
     */
    public function testAddOrUpdateConfigurationThrowsSoapFaultOnFail()
    {
       $this->fixture->addOrUpdateConfiguration($this->invalidNewConfig);
    }

    /**
     * @covers ConnectWiseApi\Configuration::addOrUpdateConfigurationType
     */
    public function testAddOrUpdateConfigurationTypeReturnsArrayOnSuccess()
    {
        // Random config type name so we don't run into non-unique name error
        $this->validNewConfigType['Name'] = $this->randomString;

        // Remove Id so this is considered a new entry.
        // Change to valid Id to test pulling an existing config type
        $this->validNewConfigType['Id'] = '';

        $this->assertTrue(is_array($this->fixture->addOrUpdateConfigurationType($this->validNewConfigType)));
    }

    /**
     * @covers ConnectWiseApi\Configuration::addOrUpdateConfigurationType
     *
     * @expectedException SoapFault
     */
    public function testAddOrUpdateConfigurationTypeThrowsSoapFaultOnFail()
    {
       $this->fixture->addOrUpdateConfigurationType($this->invalidNewConfigType);
    }

    /**
     * @covers ConnectWiseApi\Configuration::findConfigurationTypes
     **/
    public function testFindConfigurationTypesBadParam()
    {
        // Set these to whatever to test parameter value type fails
        $limit = 654.5;                 // expects integer
        $skip = 'f';                    // expects integer
        $conditions = 'sdf = sdfsd';    // expects string
        $orderBy = 2;                   // expects string

        try
        {
            $this->fixture->findConfigurationTypes($limit, $skip, $conditions, $orderBy);    
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::findConfigurations
     **/
    public function testFindConfigurationsBadParam()
    {
        // Set these to whatever to test parameter value type fails
        $limit = 654.5;                 // expects integer
        $skip = 'f';                    // expects integer
        $conditions = 'sdf = sdfsd';    // expects string
        $orderBy = 2;                   // expects string

        try
        {
            $this->fixture->findConfigurations($limit, $skip, $conditions, $orderBy);    
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::findConfigurationsCount
     **/
    public function testFindConfigurationsCountBadParam()
    {
        $isOpen = 5;          // expects boolean
        $conditions = array();   // expects string

        try
        {
            $this->fixture->findConfigurationsCount($isOpen, $conditions);
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::getConfiguration
     **/
    public function testGetConfigurationWithInvalidId()
    {
        $this->assertCount(0, $this->fixture->getConfiguration(999));
    }

    /**
     * @covers ConnectWiseApi\Configuration::getConfiguration
     * 
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testGetConfigurationWithBadParam()
    {
        $this->fixture->getConfiguration('sdzx');
    }

    /**
     * @covers ConnectWiseApi\Configuration::getConfigurationType
     **/
    public function testGetConfigurationTypeWithInvalidId()
    {
        $this->assertCount(0, $this->fixture->getConfigurationType(999));
    }

    /**
     * @covers ConnectWiseApi\Configuration::getConfigurationType
     * 
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testGetConfigurationTypeWithBadParam()
    {
        $this->fixture->getConfigurationType('lskjsdf');
    }

    /**
     * @covers ConnectWiseApi\Configuration::loadConfiguration
     **/
    public function testLoadConfigurationWithBadParam()
    {
        try
        {
            $this->fixture->loadConfiguration(999);
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::loadConfigurationType
     **/
    public function testLoadConfigurationTypeWithBadParam()
    {
        try
        {
            $this->fixture->loadConfigurationType(999);
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::updateConfiguration
     **/
    public function testUpdateConfigurationWithInvalidArray()
    {
        try
        {
            $this->fixture->updateConfiguration($this->invalidUpdateConfig);
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::updateConfiguration
     **/
    public function testUpdateConfigurationSuccess()
    {
        $this->assertTrue(is_array($this->fixture->updateConfiguration($this->validUpdateConfig)));
    }

    /**
     * @covers ConnectWiseApi\Configuration::updateConfigurationType
     **/
    public function testUpdateConfigurationTypeWithInvalidArray()
    {
        try
        {
            $this->fixture->updateConfigurationType($this->invalidUpdateConfigType);
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::updateConfigurationType
     **/
    public function testUpdateConfigurationTypeSuccess()
    {
        $this->assertTrue(is_array($this->fixture->updateConfigurationType($this->validUpdateConfigType)));
    }

    /**
     * @covers ConnectWiseApi\Configuration::deleteConfiguration
     **/
    public function testDeleteConfigurationInvalidId()
    {
        try
        {
            $this->fixture->deleteConfiguration(99); // Referenced by 23 service requests
            // $this->fixture->deleteConfiguration('sdfsdf');
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::deleteConfiguration
     **/
    public function testDeleteConfigurationNotFound()
    {
        $this->assertCount(0, $this->fixture->deleteConfiguration(9987));
    }

    /**
     * @covers ConnectWiseApi\Configuration::deleteConfigurationType
     **/
    public function testDeleteConfigurationTypeInvalidId()
    {
        try
        {
            $this->fixture->deleteConfigurationType('sdfsdf');
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::deleteConfigurationType
     **/
    public function testDeleteConfigurationTypeNotFound()
    {
        $this->assertCount(0, $this->fixture->deleteConfigurationType(9987));
    }

    /**
     * @covers ConnectWiseApi\Configuration::deleteConfigurationTypeQuestion
     **/
    public function testDeleteConfigurationTypeQuestionInvalidId()
    {
        try
        {
            $this->fixture->deleteConfigurationTypeQuestion(9987);
            // $this->fixture->deleteConfigurationTypeQuestion('sdfsdf');
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }

    /**
     * @covers ConnectWiseApi\Configuration::deletePossibleResponse
     **/
    public function testDeletePossibleResponseInvalidId()
    {
        try
        {
            // $this->fixture->deletePossibleResponse(9987);
            $this->fixture->deletePossibleResponse('sdfsdf');
        }
        catch (Exception $error)
        {
            if ($error instanceof ConnectWiseApi\ApiException OR $error instanceof SoapFault)
            {
                return;
            }
        }

        // If we got this far, neither an ApiException or SoapFault was caught
        $this->fail('Neither ApiException or SoapFault has been raised.');
    }
}