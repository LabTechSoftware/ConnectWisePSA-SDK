<?php namespace ConnectWiseApi;

/**
 * API Exception
 *
 * @package API
 */
class ApiException extends \Exception
{
    public function __construct($message, $code = 0, $previous = null)
    {
        // Custom ConnectWise API Exception Message
        $apiMessage = 'ConnectWise API Error: ' . $message;

        // Run parent construct using custom message
        parent::__construct($apiMessage, $code, $previous);
    }
}