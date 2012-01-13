<?php


class CWConfigurationAPI extends ConnectWisePSA
{
	function __construct($CW_ROOT_DOMAIN="", $CW_COMPANY="", $CW_INTEGREATOR_USERNAME="", $CW_INTEGREATOR_PASSWORD="")
	{
		parent::__construct($CW_ROOT_DOMAIN, $CW_COMPANY, $CW_INTEGREATOR_USERNAME, $CW_INTEGREATOR_PASSWORD);
		$this->TheAPIType = 'ConfigurationAPI';
	}


    public function FindConfigurations($params=array())
    {
        
        $params2['credentials'] = $this->credentials;
        if($params['conditions'] != '') { $params2['conditions'] = $params['conditions']; }
        if($params['orderBy'] != '') { $params2['orderBy'] = $params['orderBy']; }
        $params2['limit'] = round($params['limit']);
        $params2['skip'] = round($params['skip']);
        
        try
        {
            $results = $this->Call('FindConfigurations', $params2);
            if(is_soap_fault($results)) { throw $results; }
            return $results;
        }
        catch(SoapFault $fault) { return $fault;  }
    }
    public function FindConfigurationTypes($params=array())
    {
        
        $params2['credentials'] = $this->credentials;
        if($params['conditions'] != '') { $params2['conditions'] = $params['conditions']; }
        if($params['orderBy'] != '') { $params2['orderBy'] = $params['orderBy']; }
        $params2['limit'] = round($params['limit']);
        $params2['skip'] = round($params['skip']);
        
        try
        {
            $results = $this->Call('FindConfigurationTypes', $params2);
            if(is_soap_fault($results)) { throw $results; }
            return $results;
        }
        catch(SoapFault $fault) { return $fault;  }
    }

}



