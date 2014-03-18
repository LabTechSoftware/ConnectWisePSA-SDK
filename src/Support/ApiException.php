<?php namespace LabtechSoftware\ConnectwisePsaSdk\Support;

use Exception;

/**
 * API Exception
 *
 * @package ConnectwisePsaSdk
 */
class ApiException extends Exception
{
    /**
     * Looks for specific SOAP errors in exception message strings
     *
     * @return void
     */
    public function __construct($message, $code = 0, $previous = null)
    {
        // SOAP Error in exception message string?
        if (strpos($message, 'SOAP-ERROR: ') !== false) {

            // Just get the text after 'SOAP-ERROR'
            $splitMessage = explode('SOAP-ERROR: ', $message);

            // Ensure we use the correct array key from the soap exception
            // Get the message text if array key of 1 exists
            // Get the default (0 index) if not
            if (array_key_exists(1, $splitMessage) === true) {
                $message = $splitMessage[1];
            } else {
                $message = $splitMessage[0];
            }
        }

        // Add simple prefix so devs know exception is coming from this SDK
        $apiMessage = "ConnectWise API: $message";

        // Run parent construct using custom message
        parent::__construct($apiMessage, $code, $previous);
    }
}