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
        // SOAP Error?
        if (strpos($message, 'SOAP-ERROR: ') !== false)
        {
            // Just get the text after 'SOAP-ERROR'
            $splitMessage = explode('SOAP-ERROR: ', $message);

            // Ensure we use the correct array key from the soap exception (should always be 1)
            if (array_key_exists(1, $splitMessage) === true)
            {
                // Get the message text
                $message = $splitMessage[1];
            }
            else
            {
                // Default -- get whatever the value is for key 0
                $message = $splitMessage[0];
            }
        }

        // Custom ConnectWise API Exception Message
        $apiMessage = 'ConnectWise API Error: ' . $message;

        // Run parent construct using custom message
        parent::__construct($apiMessage, $code, $previous);
    }
}