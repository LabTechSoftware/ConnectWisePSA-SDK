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
        // Set the config class instance
        $this->fixture = new ConnectWiseApi\Configuration;

        // Set a random string to use in tests
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
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testAddConfigurationThrowsExceptionOnFail()
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
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testAddConfigurationTypeThrowsExceptionOnFail()
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
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testAddOrUpdateConfigurationThrowsExceptionOnFail()
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
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testAddOrUpdateConfigurationTypeThrowsExceptionOnFail()
    {
       $this->fixture->addOrUpdateConfigurationType($this->invalidNewConfigType);
    }

    /**
     * @covers ConnectWiseApi\Configuration::findConfigurationTypes
     *
     * @expectedException ConnectWiseApi\ApiException
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
     * @covers ConnectWiseApi\Configuration::findConfigurations
     *
     * @expectedException ConnectWiseApi\ApiException
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
     * @covers ConnectWiseApi\Configuration::findConfigurationsCount
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testFindConfigurationsCountBadParamThrowsException()
    {
        $isOpen = 5;          // expects boolean
        $conditions = array();   // expects string

        $this->fixture->findConfigurationsCount($isOpen, $conditions);
    }

    /**
     * @covers ConnectWiseApi\Configuration::getConfiguration
     **/
    public function testGetConfigurationWithInvalidIdReturnsEmptyArray()
    {
        $this->assertCount(0, $this->fixture->getConfiguration(999));
    }

    /**
     * @covers ConnectWiseApi\Configuration::getConfiguration
     * 
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testGetConfigurationWithBadParamThrowsException()
    {
        $this->fixture->getConfiguration('sdzx');
    }

    /**
     * @covers ConnectWiseApi\Configuration::getConfigurationType
     **/
    public function testGetConfigurationTypeWithInvalidIdReturnsEmptyArray()
    {
        $this->assertCount(0, $this->fixture->getConfigurationType(999));
    }

    /**
     * @covers ConnectWiseApi\Configuration::getConfigurationType
     * 
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testGetConfigurationTypeWithBadParamThrowsException()
    {
        $this->fixture->getConfigurationType('lskjsdf');
    }

    /**
     * @covers ConnectWiseApi\Configuration::loadConfiguration
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testLoadConfigurationWithBadParamThrowsException()
    {
        $this->fixture->loadConfiguration(999);
    }

    /**
     * @covers ConnectWiseApi\Configuration::loadConfigurationType
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testLoadConfigurationTypeWithBadParamThrowsException()
    {
        $this->fixture->loadConfigurationType(999);
    }

    /**
     * @covers ConnectWiseApi\Configuration::updateConfiguration
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testUpdateConfigurationWithInvalidArrayThrowsException()
    {
        $this->fixture->updateConfiguration($this->invalidUpdateConfig);
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
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testUpdateConfigurationTypeWithInvalidArrayThrowsException()
    {
        $this->fixture->updateConfigurationType($this->invalidUpdateConfigType);
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
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testDeleteConfigurationInvalidIdThrowsException()
    {
        $this->fixture->deleteConfiguration(99); // "Referenced by 23 service requests"
        // $this->fixture->deleteConfiguration('sdfsdf');
    }

    /**
     * @covers ConnectWiseApi\Configuration::deleteConfiguration
     **/
    public function testDeleteConfigurationNotFoundReturnsEmptyArray()
    {
        $this->assertCount(0, $this->fixture->deleteConfiguration(9987));
    }

    /**
     * @covers ConnectWiseApi\Configuration::deleteConfigurationType
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testDeleteConfigurationTypeInvalidIdThrowsException()
    {
        $this->fixture->deleteConfigurationType('sdfsdf');
    }

    /**
     * @covers ConnectWiseApi\Configuration::deleteConfigurationType
     **/
    public function testDeleteConfigurationTypeNotFoundReturnsEmptyArray()
    {
        $this->assertCount(0, $this->fixture->deleteConfigurationType(9987));
    }

    /**
     * @covers ConnectWiseApi\Configuration::deleteConfigurationTypeQuestion
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testDeleteConfigurationTypeQuestionInvalidIdThrowsException()
    {
        $this->fixture->deleteConfigurationTypeQuestion(9987);
        // $this->fixture->deleteConfigurationTypeQuestion('sdfsdf');
    }

    /**
     * @covers ConnectWiseApi\Configuration::deletePossibleResponse
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testDeletePossibleResponseInvalidIdThrowsException()
    {
        // $this->fixture->deletePossibleResponse(9987);
        $this->fixture->deletePossibleResponse('sdfsdf');
    }
}