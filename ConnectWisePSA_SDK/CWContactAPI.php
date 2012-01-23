<?php


class CWContactAPI extends ConnectWisePSA_SDK
{
	function __construct($CW_ROOT_DOMAIN="", $CW_COMPANY="", $CW_INTEGREATOR_USERNAME="", $CW_INTEGREATOR_PASSWORD="")
	{
		parent::__construct($CW_ROOT_DOMAIN, $CW_COMPANY, $CW_INTEGREATOR_USERNAME, $CW_INTEGREATOR_PASSWORD);
		$this->TheAPIType = 'ContactAPI';
	}


	public function Authenticate($params=array())
	{
		
		$params2['email'] = $params['email'];
		$params2['loginpw'] = $params['loginpw'];
		$params2['portalName'] = $params['portalName'];
		
		try
		{
			$results = $this->Call('Authenticate', $params2);
			if(is_soap_fault($results)) { throw $results; }
			return $results->AuthenticateResult;
		}
		catch(SoapFault $fault) { return $fault;  }
	}
	public function GetContact($cwid)
	{
		$params['credentials'] = $this->credentials;
		$params['id'] = $cwid;
		$results = $this->Call('GetContact', $params);
		$results = $results->GetContactResult;
		
		if(round($results->ContactRecID) > 0) { return $results; }
		if(round($results->ContactRecID) == 0) { return false; }
	}
}



