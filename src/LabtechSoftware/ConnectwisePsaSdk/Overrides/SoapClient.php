<?php namespace LabtechSoftware\ConnectwisePsaSdk\Overrides;

/**
 * This version of SoapClient forces the requests to be made over HTTPS
 * if the WSDL was loaded over HTTPS.
 *
 * This is a workaround for an issue with ConnectWise WSDLs.
 */
class SoapClient extends \SoapClient
{
    public $wsdl;

    public function __construct($wsdl, $options = null) {
        $this->wsdl = $wsdl;
        parent::__construct($wsdl, $options);
    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        if (strpos($this->wsdl, 'https://') === 0) {
            $location = str_replace('http://', 'https://', $location);
        }
        return parent::__doRequest($request, $location, $action, $version, $one_way);
    }
}