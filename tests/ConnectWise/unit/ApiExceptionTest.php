<?php

use LabtechSoftware\ConnectwisePsaSdk\ApiException;

class ApiExceptionTest extends PHPUnit_Framework_testCase
{
    public function testConstructorWithMessageNotPrefixedWithSoapError()
    {
        $apiException = new ApiException('An exception message.', 0, null);

        $this->assertEquals('ConnectWise API Error: An exception message.', $apiException->getMessage());
    }

    public function testConstructorWithMessagePrefixedWithSoapError()
    {
        $apiException = new ApiException('SOAP-ERROR: Could not reach CW API', 0, null);

        $this->assertEquals('ConnectWise API Error: Could not reach CW API', $apiException->getMessage());
    }


    public function testConstructorWithOnlySoapErrorInMessage()
    {
        $apiException = new ApiException('SOAP-ERROR:', 0, null);

        $this->assertEquals('ConnectWise API Error: SOAP-ERROR:', $apiException->getMessage());
    }
}
