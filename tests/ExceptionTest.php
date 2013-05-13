<?php require dirname(__FILE__).'/../api.php'; 

use ConnectWiseApi\ApiException,
    ConnectWiseApi\Configuration,
    ConnectWiseApi\Contact,
    ConnectWiseApi\Reporting,
    ConnectWiseApi\ServiceTicket;

class ExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException        ApiException
     * @expectedExceptionMessage Money Message
     */
    public function testExceptionHasRightMessage()
    {
        throw new ApiException('Some Message', 10);
    }
 
    /**
     * @expectedException     ApiException
     * @expectedExceptionCode 20
     */
    public function testExceptionHasRightCode()
    {
        throw new ApiException('Some Message', 10);
    }
}