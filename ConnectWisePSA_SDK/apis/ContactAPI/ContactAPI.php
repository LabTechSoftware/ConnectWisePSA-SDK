<?php namespace ConnectWisePSA;

include_once dirname(__FILE__)."/request.php";

class ContactAPI extends ConnectWisePSABase
{
    function __construct()
    {
        parent::__construct();
        $this->CurrentAPI = 'ContactAPI';
	}
    
    public function AddContactToGroup()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function AddOrUpdateContact()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function AddOrUpdateContactCommunicationItem()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function AddOrUpdateContactNote()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

	/**
	 * This is a very dangerous method right now. You should not use this unless you know what it does.
	 * I reccomend if your trying to authenticate via portal password you use the FindContacts method
	 * @param array $params email, loginpw and portalName please.
	 */
	public function Authenticate($params=array())
	{
		
		$params2['email'] = $params['email'];
		$params2['loginpw'] = $params['loginpw'];
		$params2['portalName'] = $params['portalName'];
		
		try
		{
			$results = $this->call('Authenticate', $params2);
			if(is_soap_fault($results)) { throw $results; }
			return $results->AuthenticateResult;
		}
		catch(SoapFault $fault) { return $fault;  }
	}
    
    public function DeleteContact()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function DeleteContactCommunicationItem()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function DeleteNote()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function FindCompanies()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    /**
     * Finds contact information by a set of conditions.
     * @param string  $conditions [description]
     * @param integer $limit      Limits the number of results a query should return
     * @param integer $skip       How many to skip, good for pagination
     * @param string  $orderBy    Which property to sort by.
     */
    public function FindContacts($conditions="", $limit=0, $skip=0, $orderBy="")
    {
        $params['credentials'] = $this->credentials;
        if($conditions != '') { $params['conditions'] = $conditions; }
        if($orderBy != '') { $params['orderBy'] = $orderBy; }
        $params['limit'] = $limit;
        $params['skip'] = $skip;
        
        try
        {
            $results = $this->call('FindContacts', $params);
            if(is_soap_fault($results)) { throw $results; }

            // Lets narrow it down a little bit
            $results = $results->FindContactsResult->ContactFindResult;
            
            // Object wtf? Lets turn it into an array so its always the same.
            if(is_object($results)) { $results = array($results); }

            return $results;
        }
        catch(SoapFault $fault) { return $fault;  }
    }
    
    public function FindContactsCount()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    // WTF?
    public function GetAllCommunicationTypesAndDescription()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetAllContactCommunicationItems()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetAllContactNotes()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetAvatarImage()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetContact($Contact_RecID)
	{
		$params['credentials'] = $this->credentials;
		$params['id'] = $Contact_RecID;
		$results = $this->call('GetContact', $params);
		$results = $results->GetContactResult;
		
		if(round($results->ContactRecID) > 0) { return $results; }
		if(round($results->ContactRecID) == 0) { return false; }
	}
    
    public function GetContactCommunicationItem()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetContactNote()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetPortalConfigSettings()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetPortalLoginCustomizations()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetPortalSecurity()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function LoadContact()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function RemoveContactFromGroup()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function RequestPassword()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function SetDefaultContactCommunicationItem()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
}



