<?php namespace ConnectWisePSA;



class ConfigurationAPI extends ConnectWisePSABase
{
    function __construct()
    {
        parent::__construct();
		$this->CurrentAPI = 'ConfigurationAPI';
	}

    public function AddConfiruration()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function AddConfirurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function AddOrUpdateConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function AddOrUpdateConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function DeleteConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function DeleteConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function DeleteConfigurationTypeQuestion()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function DeletePossibleResponse()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
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
            $results = $this->call('FindConfigurations', $params2);
            if(is_soap_fault($results)) { throw $results; } // This is incase of an error.

            // Lets narrow it down a little bit
            $results = $results->FindConfigurationsResult->ConfigurationFindResult;
            
            // Object wtf? Lets turn it into an array so its always the same.
            if(is_object($results)) { $results = array($results); }

            return $results;
        }
        catch(SoapFault $fault) { return $fault;  }
    }

    public function FindConfigurationsCount()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
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
            $results = $this->call('FindConfigurationTypes', $params2);
            if(is_soap_fault($results)) { throw $results; } // This is incase of an error.

            // Lets narrow it down a little bit
            $results = $results->FindConfigurationTypesResult->ConfigurationTypeFindResult;
            
            // Object wtf? Lets turn it into an array so its always the same.
            if(is_object($results)) { $results = array($results); }

            return $results;
        }
        catch(SoapFault $fault) { return $fault;  }
    }

    public function GetConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function GetConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function LoadConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function LoadConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function UpdateConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public function UpdateConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

}



