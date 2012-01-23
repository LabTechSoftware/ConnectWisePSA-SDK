<?php




class ConnectWisePSA_SDK
{
	public $CW_ROOT_DOMAIN, $CW_COMPANY, $CW_INTEGREATOR_USERNAME, $CW_INTEGREATOR_PASSWORD, $TheAPIType, $TheSoapOptions, $TheSoapObject;

	function __construct($CW_ROOT_DOMAIN="", $CW_COMPANY="", $CW_INTEGREATOR_USERNAME="", $CW_INTEGREATOR_PASSWORD="")
	{
		// check for default login information
		/* I WANT TO DO THIS BETTER */
		if($CW_ROOT_DOMAIN == '') { defined('CW_ROOT_DOMAIN') or die('Please set CW_ROOT_DOMAIN'); $CW_ROOT_DOMAIN = CW_ROOT_DOMAIN; }
		if($CW_COMPANY == '') { defined('CW_COMPANY') or die('Please set CW_COMPANY'); $CW_COMPANY = CW_COMPANY; }
		if($CW_INTEGREATOR_USERNAME == '') { defined('CW_INTEGREATOR_USERNAME') or die('Please set CW_INTEGREATOR_USERNAME'); $CW_INTEGREATOR_USERNAME = CW_INTEGREATOR_USERNAME; }
		if($CW_INTEGREATOR_PASSWORD == '') { defined('CW_INTEGREATOR_PASSWORD') or die('Please set CW_INTEGREATOR_PASSWORD'); $CW_INTEGREATOR_PASSWORD = CW_INTEGREATOR_PASSWORD; }
	
		$this->CW_ROOT_DOMAIN = $CW_ROOT_DOMAIN;
		$this->credentials['CompanyId'] = $CW_COMPANY;
		$this->credentials['IntegratorLoginId'] = $CW_INTEGREATOR_USERNAME;
		$this->credentials['IntegratorPassword'] = $CW_INTEGREATOR_PASSWORD;
		
		
		// Basic Soap Options
		$this->TheSoapOptions = array( 
			'soap_version'=>SOAP_1_1, 
			'exceptions'=>true, 
			'trace'=>1, 
			'cache_wsdl'=>WSDL_CACHE_NONE 
		); 		
	
	
	}
	
    /*
     * This is a method created so we can if needed abstract the actual API call and use other libraries like nusoap or Zend's soap stuff.
     * Because poor windows doesnt like PHP 5.3
     * 
     * @param string $method this is the method your wanting to call from the api
     * @param array $params this is an array of the methods parameters.
     * @returns SoapObject 
     */
	public function Call($method, $params)
	{
		$wsdl = 'https://'.$this->CW_ROOT_DOMAIN.'/v4_6_release/apis/1.5/'.$this->TheAPIType.'.asmx?wsdl';
	
		if(class_exists(SoapClient))
		{
			try
			{
				if(!@file_get_contents($wsdl)) { throw new SoapFault('Server', 'Error loading WSDL: ' . $wsdl); }
				$TheSoapObject = new SoapClient($wsdl, $this->TheSoapOptions);
				return $TheSoapObject->__call($method, array($params));
			}
			catch(SoapFault $fault) { return $fault;  }
		}
		else
		{
			return new SoapFault('Server', 'No so client available.');	
		}
	}
	
	
	/*
     * This is the autoloader for all the SDK's classes
     */
	public static function autoloader($name)
	{
		if(strtolower(substr($name, 0, 2)) == 'cw' && is_file(dirname(__FILE__)."/".$name.".php")) { include_once dirname(__FILE__)."/".$name.".php"; }
	}

}
// Register the autoloader.
spl_autoload_register(array('ConnectWisePSA_SDK', 'autoloader'));