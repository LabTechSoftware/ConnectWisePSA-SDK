<?php

/**
 * Tests for \ConnectwisePsaSdk\Configuration
 *
 * @covers ConnectwisePsaSdk\Configuration
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
        // Set the config class instance
        $this->fixture = new ConnectwisePsaSdk\Configuration;

        // Set a random string to use in tests
        $this->randomString = 'Test Entry num' . rand(10, 1000);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration
     */
    public function testCurrentApiNameExists()
    {
        $this->assertObjectHasAttribute('currentApi', $this->fixture);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::addConfiguration
     */
    public function testAddConfigurationReturnsArrayOnSuccess()
    {
        // Random config type name so we don't run into non-unique name error
        $this->validNewConfig['ConfigurationName'] = $this->randomString;

        $this->assertTrue(is_array($this->fixture->addConfiguration($this->validNewConfig)));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::addConfiguration
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddConfigurationThrowsExceptionOnFail()
    {
       $this->fixture->addConfiguration($this->invalidNewConfig);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::addConfigurationType
     */
    public function testAddConfigurationTypeReturnsArrayOnSuccess()
    {
        // Random config type name so we don't run into non-unique name error
        $this->validNewConfigType['Name'] = $this->randomString;

        $this->assertTrue(is_array($this->fixture->addConfigurationType($this->validNewConfigType)));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::addConfigurationType
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddConfigurationTypeThrowsExceptionOnFail()
    {
       $this->fixture->addConfigurationType($this->invalidNewConfigType);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::addOrUpdateConfiguration
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
     * @covers ConnectwisePsaSdk\Configuration::addOrUpdateConfiguration
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateConfigurationThrowsExceptionOnFail()
    {
       $this->fixture->addOrUpdateConfiguration($this->invalidNewConfig);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::addOrUpdateConfigurationType
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
     * @covers ConnectwisePsaSdk\Configuration::addOrUpdateConfigurationType
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateConfigurationTypeThrowsExceptionOnFail()
    {
       $this->fixture->addOrUpdateConfigurationType($this->invalidNewConfigType);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::findConfigurationTypes
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testFindConfigurationTypesBadParamThrowsException()
    {
        // Set these to whatever to test parameter value type fails
        $limit = 654.5;                 // expects integer
        $skip = 'f';                    // expects integer
        $conditions = 'sdf = sdfsd';    // expects string
        $orderBy = 2;                   // expects string

        $this->fixture->findConfigurationTypes($limit, $skip, $conditions, $orderBy);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::findConfigurations
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testFindConfigurationsBadParamThrowsException()
    {
        // Set these to whatever to test parameter value type fails
        $limit = 654.5;                 // expects integer
        $skip = 'f';                    // expects integer
        $conditions = 'sdf = sdfsd';    // expects string
        $orderBy = 2;                   // expects string

        $this->fixture->findConfigurations($limit, $skip, $conditions, $orderBy);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::findConfigurationsCount
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testFindConfigurationsCountBadParamThrowsException()
    {
        $isOpen = 5;          // expects boolean
        $conditions = array();   // expects string

        $this->fixture->findConfigurationsCount($isOpen, $conditions);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::getConfiguration
     **/
    public function testGetConfigurationWithInvalidIdReturnsEmptyArray()
    {
        $this->assertCount(0, $this->fixture->getConfiguration(999));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::getConfiguration
     * 
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testGetConfigurationWithBadParamThrowsException()
    {
        $this->fixture->getConfiguration('sdzx');
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::getConfigurationType
     **/
    public function testGetConfigurationTypeWithInvalidIdReturnsEmptyArray()
    {
        $this->assertCount(0, $this->fixture->getConfigurationType(999));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::getConfigurationType
     * 
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testGetConfigurationTypeWithBadParamThrowsException()
    {
        $this->fixture->getConfigurationType('lskjsdf');
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::loadConfiguration
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testLoadConfigurationWithBadParamThrowsException()
    {
        $this->fixture->loadConfiguration(999);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::loadConfigurationType
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testLoadConfigurationTypeWithBadParamThrowsException()
    {
        $this->fixture->loadConfigurationType(999);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::updateConfiguration
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testUpdateConfigurationWithInvalidArrayThrowsException()
    {
        $this->fixture->updateConfiguration($this->invalidUpdateConfig);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::updateConfiguration
     **/
    public function testUpdateConfigurationSuccess()
    {
        $this->assertTrue(is_array($this->fixture->updateConfiguration($this->validUpdateConfig)));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::updateConfigurationType
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testUpdateConfigurationTypeWithInvalidArrayThrowsException()
    {
        $this->fixture->updateConfigurationType($this->invalidUpdateConfigType);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::updateConfigurationType
     **/
    public function testUpdateConfigurationTypeSuccess()
    {
        $this->assertTrue(is_array($this->fixture->updateConfigurationType($this->validUpdateConfigType)));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::deleteConfiguration
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testDeleteConfigurationInvalidIdThrowsException()
    {
        $this->fixture->deleteConfiguration(99); // "Referenced by 23 service requests"
        // $this->fixture->deleteConfiguration('sdfsdf');
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::deleteConfiguration
     **/
    public function testDeleteConfigurationNotFoundReturnsEmptyArray()
    {
        $this->assertCount(0, $this->fixture->deleteConfiguration(9987));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::deleteConfigurationType
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testDeleteConfigurationTypeInvalidIdThrowsException()
    {
        $this->fixture->deleteConfigurationType('sdfsdf');
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::deleteConfigurationType
     **/
    public function testDeleteConfigurationTypeNotFoundReturnsEmptyArray()
    {
        $this->assertCount(0, $this->fixture->deleteConfigurationType(9987));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::deleteConfigurationTypeQuestion
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testDeleteConfigurationTypeQuestionInvalidIdThrowsException()
    {
        $this->fixture->deleteConfigurationTypeQuestion(9987);
        // $this->fixture->deleteConfigurationTypeQuestion('sdfsdf');
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::deletePossibleResponse
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testDeletePossibleResponseInvalidIdThrowsException()
    {
        // $this->fixture->deletePossibleResponse(9987);
        $this->fixture->deletePossibleResponse('sdfsdf');
    }
}