<?php

use LabtechSoftware\ConnectwisePsaSdk\Configuration;

/**
 * Tests for \ConnectwisePsaSdk\Configuration
 *
 * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration
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
     * Set the fixture and generate a random string
     * Also set a random string for the valid configuration array
     */
    protected function setUp()
    {
        $client = $this->getMockBuilder('LabtechSoftware\ConnectwisePsaSdk\ConnectWiseApi')
            ->disableOriginalConstructor()
            ->getMock();

        $this->fixture = new Configuration($client);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurationTypes
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationTypesThrowsExceptionWhenLimitIsNotNumeric()
    {
        $this->fixture->findConfigurationTypes('', 3, '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurationTypes
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationTypesThrowsExceptionWhenSkipIsNotNumeric()
    {
        $this->fixture->findConfigurationTypes(3, '', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurationTypes
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationTypesThrowsExceptionWhenConditionsIsNotAString()
    {
        $this->fixture->findConfigurationTypes(3, 3, 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurationTypes
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationTypesThrowsExceptionWhenOrderByIsNotAString()
    {
        $this->fixture->findConfigurationTypes(3, 3, '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurations
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationsThrowsExceptionWhenLimitIsNotNumeric()
    {
        $this->fixture->findConfigurations('', 3, '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurations
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationsThrowsExceptionWhenSkipIsNotNumeric()
    {
        $this->fixture->findConfigurations(3, '', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurations
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationsThrowsExceptionWhenConditionsIsNotAString()
    {
        $this->fixture->findConfigurations(3, 3, 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurations
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationsThrowsExceptionWhenOrderByIsNotAString()
    {
        $this->fixture->findConfigurations(3, 3, '', 3);
    }


    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurationsCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationsCountThrowsExceptionWhenIsOpenIsNotBoolean()
    {
        $this->fixture->findConfigurationsCount(3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::findConfigurationsCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindConfigurationsCountThrowsExceptionWhenConditionsIsNotAString()
    {
        $this->fixture->findConfigurationsCount(3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::getConfiguration
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetConfigurationThrowsExceptionWhenIdIsNotNumeric()
    {
        $this->fixture->getConfiguration('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::getConfigurationType
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetConfigurationTypeThrowsExceptionWhenIdIsNotNumeric()
    {
        $this->fixture->getConfigurationType('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::deleteConfiguration
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteConfigurationThrowsExceptionWhenIdIsNotNumeric()
    {
        $this->fixture->deleteConfiguration('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::deleteConfigurationType
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteConfigurationTypeThrowsExceptionWhenIdIsNotNumeric()
    {
        $this->fixture->deleteConfigurationType('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::deleteConfigurationTypeQuestion
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteConfigurationTypeQuestionThrowsExceptionWhenIdIsNotNumeric()
    {
        $this->fixture->deleteConfigurationTypeQuestion('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Configuration::deletePossibleResponse
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeletePossibleResponseThrowsExceptionWhenIdIsNotNumeric()
    {
        $this->fixture->deletePossibleResponse('');
    }
}
