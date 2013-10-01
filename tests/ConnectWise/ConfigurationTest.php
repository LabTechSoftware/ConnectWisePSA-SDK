<?php

use LabtechSoftware\ConnectwisePsaSdk\Configuration;

/**
 * Tests for \ConnectwisePsaSdk\Configuration
 *
 * @covers ConnectwisePsaSdk\Configuration
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Configuration instance goes here
     *
     * @var LabtechSoftware\ConnectwisePsaSdk\Configuration
     */
    protected $fixture;

    /**
     * Random string for changing titles, etc stored here 
     * The random string is created at runtime in setUp()
     *
     * @see setUp()
     * @var string
     */
    protected $randomString;

    /**
     * This data gets used to create new configurations
     *
     * @var array
     */
    protected $validNewConfig = array(
        'Id' => 99, 'ConfigurationTypeId' => 1, 'ConfigurationType' => 'License', 'StatusId' => 1, 
        'ConfigurationName' => 'Testing 123', 'CompanyId' => '99'
    );

    /**
     * When a new configuration is created, the data will get saved here
     * 
     * @var array
     */
    protected $newCreatedConfig = array();

    /**
     * An invalid new configuration for config creation failure testing
     *
     * @var array
     */
    protected $invalidNewConfig = array(
        'ConfigurationType' => 'License', 'StatusId' => 1, 'ConfigurationName' => 'PSA Software Test 02'
    );

    /**
     * Valid new config type for successful testing of creating new config types
     *
     * @var array
     */
    protected $validNewConfigType = array(
        'Id' => 99, 'Name' => '', 'InactiveFlag' => false, 'SystemFlag' => true
    );

    /**
     * Newly created config type data get stored here to be used in future tests
     *
     * @var array
     */
    protected $validUpdateConfigType = array();

    /**
     * Invalid new config type for testing new config type creation failures
     *
     * @var array
     */
    protected $invalidNewConfigType = array(
        'Name' => 'Test Config Type', 'InactiveFlag' => false, 'SystemFlag' => true
    );

    /**
     * Invalid config type array for failure tests
     *
     * @var array
     */
    protected $invalidUpdateConfigType = array('InactiveFlag' => false, 'SystemFlag' => true);

    /**
     * Set the fixture and generate a random string
     * Also set a random string for the valid configuration array
     */
    protected function setUp()
    {
        // Set the config class instance
        $this->fixture = new Configuration;

        // Set a random string to use in tests
        $this->randomString = 'Test Entry num' . rand(10, 1000);

        // Random config type name so we don't run into non-unique name error when creating configs
        $this->validNewConfig['ConfigurationName'] = $this->randomString;

        // Random config type name so we don't run into non-unique name error
        $this->validNewConfigType['Name'] = $this->randomString;
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
        // Put the new config into a var so we can save it as a class property for later use
        // e.g. updating configs
        $getNewConfig = $this->fixture->addConfiguration($this->validNewConfig);

        // Save the new config to a class property so we can use the data for testing later
        $this->newCreatedConfig = $getNewConfig;

        // Tests...
        $this->assertTrue(is_array($getNewConfig));
        $this->assertGreaterThan(10, count($getNewConfig));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::addConfiguration
     *
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
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
        $addConfigType = $this->fixture->addConfigurationType($this->validNewConfigType);

        // Save the new config type entry for testing later on...
        $this->validUpdateConfigType = $addConfigType;

        // Tests...
        $this->assertTrue(is_array($addConfigType));
        $this->assertGreaterThan(4, count($addConfigType));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::addConfigurationType
     *
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
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
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
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
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateConfigurationTypeThrowsExceptionOnFail()
    {
       $this->fixture->addOrUpdateConfigurationType($this->invalidNewConfigType);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::findConfigurationTypes
     *
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
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
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
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
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     **/
    public function testFindConfigurationsCountBadParamThrowsException()
    {
        $isOpen = 5;            // expects boolean
        $conditions = array();  // expects string

        $this->fixture->findConfigurationsCount($isOpen, $conditions);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::getConfiguration
     **/
    public function testGetConfigurationWithInvalidIdReturnsEmptyArray()
    {
        $this->assertCount(0, $this->fixture->getConfiguration(9999));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::getConfiguration
     * 
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
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
        $this->assertCount(0, $this->fixture->getConfigurationType(9999));
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::getConfigurationType
     * 
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     **/
    public function testGetConfigurationTypeWithBadParamThrowsException()
    {
        $this->fixture->getConfigurationType('lskjsdf');
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::loadConfiguration
     *
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     **/
    public function testLoadConfigurationWithBadParamThrowsException()
    {
        $this->fixture->loadConfiguration(999);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::loadConfigurationType
     *
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     **/
    public function testLoadConfigurationTypeWithBadParamThrowsException()
    {
        $this->fixture->loadConfigurationType(999);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::updateConfiguration
     *
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     **/
    public function testUpdateConfigurationWithInvalidArrayThrowsException()
    {
        // Get valid data and put in var so we don't overwrite whats stored there already
        $getConfigData = $this->validNewConfig;

        // Set some invalid values
        $getConfigData['Id'] = 'zz';
        $getConfigData['ConfigurationTypeId'] = 'xx0398js';

        // Run method
        $this->fixture->updateConfiguration($getConfigData);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::updateConfiguration
     **/
    public function testUpdateConfigurationSuccess()
    {
        // Create a new configuration and put the data/result into a var for later use
        $createConfig = $this->fixture->addConfiguration($this->validNewConfig);

        // Run update configuration with the new data
        $updateConfigReturnData = $this->fixture->updateConfiguration($createConfig);

        // Tests...
        $this->assertTrue(is_array($updateConfigReturnData));
        $this->assertGreaterThan(10, $updateConfigReturnData);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::updateConfigurationType
     *
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
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
        // Skip this test for now -- need to know some valid config type IDs
        $this->markTestSkipped(
            'Skipped Test: Update Configuration Type. Needs live data.'
        );

        // Update the config type
        $updateConfigType = $this->fixture->updateConfigurationType();

        // Tests...
        $this->assertTrue(is_array($updateConfigType));
        $this->assertGreaterThan(4, $updateConfigType);
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::deleteConfiguration
     *
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     **/
    public function testDeleteConfigurationNonNumericIdThrowsException()
    {
        $this->fixture->deleteConfiguration('sdfsdf');
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
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
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
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     **/
    public function testDeleteConfigurationTypeQuestionInvalidIdThrowsException()
    {
        $this->fixture->deleteConfigurationTypeQuestion(9987);
        // $this->fixture->deleteConfigurationTypeQuestion('sdfsdf');
    }

    /**
     * @covers ConnectwisePsaSdk\Configuration::deletePossibleResponse
     *
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     **/
    public function testDeletePossibleResponseInvalidIdThrowsException()
    {
        // $this->fixture->deletePossibleResponse(9987);
        $this->fixture->deletePossibleResponse('sdfsdf');
    }
}