<?php namespace ConnectWisePSA;

use Exception,
	stdClass,
	SoapClient,
	SoapFault;

include_once dirname(__FILE__)."/ConnectWisePSARequest.php";

abstract class ConnectWisePSABase
{
	var $credentials = array();
	var $CurrentAPI;		
	// Basic Soap Options
	var $SoapOptions = array( 
		'soap_version'=>SOAP_1_1, 
		'exceptions'=>true, 
		'trace'=>1, 
		'cache_wsdl'=>WSDL_CACHE_NONE 
	); 		

	public function __construct()
	{
		// First lets see if they have a recent enough version of php
		if (strnatcmp(phpversion(),'5.0.1') >= 0)
		{

		}
		// Lets check if stuff is set
		$checks = array('CW_ROOT_DOMAIN', 'CW_COMPANY', 'CW_INTEGREATOR_USERNAME', 'CW_INTEGREATOR_PASSWORD');
		foreach($checks as $check)
		{
			if(!defined($check))
			{
				throw new ConnectWisePSAException($check." is not defined");
			}
		}

		// We're all good bro!
		$this->CW_ROOT_DOMAIN = CW_ROOT_DOMAIN;
		$this->credentials['CompanyId'] = CW_COMPANY;
		$this->credentials['IntegratorLoginId'] = CW_INTEGREATOR_USERNAME;
		$this->credentials['IntegratorPassword'] = CW_INTEGREATOR_PASSWORD;


	}
	
    /*
     * This is a method created so we can if needed abstract the actual API call and use other libraries like nusoap or Zend's soap stuff.
     * Because poor windows doesnt like PHP 5.3
     * 
     * @param string $method this is the method your wanting to call from the api
     * @param array $params this is an array of the methods parameters.
     * @returns SoapObject 
     */
	public function call($method, $params)
	{
		$wsdl = 'https://'.$this->CW_ROOT_DOMAIN.'/v4_6_release/apis/1.5/'.$this->CurrentAPI.'.asmx?wsdl';
	
		if(class_exists('SoapClient'))
		{
			try
			{
				if(!@file_get_contents($wsdl)) { throw new SoapFault('Server', 'Error loading WSDL: ' . $wsdl); }
				$SoapObject = new SoapClient($wsdl, $this->SoapOptions);
				return $SoapObject->__soapCall($method, array($params));
			}
			catch(SoapFault $fault) { return $fault;  }
		}
		else
		{
			return new ConnectWisePSAException('No so soap client available.');	
		}

	}

	public static function test()
	{
		$return = new stdClass;
		$return->location = get_called_class()."::".__FUNCTION__;
		$return->message = "Testing 1... 2... 3...";
		$return->args = func_get_args();
		return $return;
	}

	/*
     * This is the autoloader for all the SDK's classes
     */
	public static function autoloader($name)
	{
		list($namespace, $class) = explode('\\', $name);
		if($namespace != 'ConnectWisePSA') { return; }
		$file = dirname(__FILE__)."/apis/".$class."/".$class.".php";
		if(is_file($file)) { include_once $file; }
	}

}

class ConnectWisePSAException extends Exception { }




// Register the autoloader.
spl_autoload_register(array('ConnectWisePSA\ConnectWisePSABase', 'autoloader'));