<?php

use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory;

/**
 * @covers LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory
 */
class ConnectWiseApiFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $fixture;

    protected function setUp()
    {
        parent::setUp();
        $this->fixture = new ConnectwiseApiFactory();
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory::make
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expecting string value.
     */
    public function testMakeThrowsInvalidArgumentExceptionWhenApiIsNotAString()
    {
        $this->fixture->make(null);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory::make
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Class does not exist
     */
    public function testMakeThrowsApiExceptionWhenClassDoesNotExist()
    {
        $this->fixture->make('NonExistentClass');
    }
}


///**
// * Tests for \ConnectwisePsaSdk\Contact
// * @todo Add tests for addContactToGroup, getAvatarImage, removeContactFromGroup
// *
// * @covers LabtechSoftware\ConnectwisePsaSdk\Contact
// */
//class ConnectWiseApiFactoryTest extends \PHPUnit_Framework_TestCase
//{
//
//    protected $fixture;
//
//    protected function setUp()
//    {
//        $this->fixture = new ConnectwiseApiFactory();
//    }
//
//    public function testMakeContact()
//    {
//        $this->assertInstanceOf('LabtechSoftware\ConnectwisePsaSdk\Contact', $this->fixture->makeContact());
//    }
//
//    public function testMakeCompany()
//    {
//        $this->assertInstanceOf('LabtechSoftware\ConnectwisePsaSdk\Company', $this->fixture->makeCompany());
//    }
//
//    public function testMakeConfiguration()
//    {
//        $this->assertInstanceOf('LabtechSoftware\ConnectwisePsaSdk\Configuration', $this->fixture->makeConfiguration());
//    }
//
//    public function testMakeReporting()
//    {
//        $this->assertInstanceOf('LabtechSoftware\ConnectwisePsaSdk\Reporting', $this->fixture->makeReporting());
//    }
//
//    public function testMakeServiceTicket()
//    {
//        $this->assertInstanceOf('LabtechSoftware\ConnectwisePsaSdk\ServiceTicket', $this->fixture->makeServiceTicket());
//    }
//}
