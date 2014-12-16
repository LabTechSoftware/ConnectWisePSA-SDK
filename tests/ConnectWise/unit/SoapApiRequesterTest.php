<?php

use LabtechSoftware\ConnectwisePsaSdk\SoapApiRequester;

class SoapApiRequesterTest extends PHPUnit_Framework_TestCase
{
    protected $fixture;
    protected $soapMock;


    protected function setUp()
    {
        // build the soap mock
        $this->soapMock = $this->getMockBuilder('SoapClient')
            ->disableOriginalConstructor()
            ->getMock();

        // build the config loader mock
        $configLoaderMock = $this->getMock('LabtechSoftware\ConnectwisePsaSdk\ConfigLoader');

        // configure the config loader mock
        $configLoaderMock->expects($this->once())
            ->method('getSoapCredentials')
            ->will($this->returnValue('mock credentials'));


        // create the SUT, passing in mocks
        $this->fixture = new SoapApiRequester($this->soapMock, $configLoaderMock);
    }


    /**
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testMakeRequestThrowsExceptionWhenSoapFaultOccurs()
    {
        // configure the soap mock for this test, to throw a soap fault, which will in turn throw an API Exception
        $this->soapMock->expects($this->once())
                 ->method('__call')
                 ->with($this->equalTo('amethod'))
                 ->will($this->throwException(new SoapFault('a soap fault', '')));

        $this->fixture->makeRequest('amethod');
    }


    public function testMakeRequestReturnsEmptyArrayWhenNoSoapFault()
    {
        // configure the soap mock for this test, to return an empty array (opposed to an API Exception when error)
        $this->soapMock->expects($this->once())
            ->method('__call')
            ->with($this->equalTo('amethod'))
            ->will($this->returnValue(array()));

        $this->assertInternalType('array', $this->fixture->makeRequest('amethod'));
    }
}
