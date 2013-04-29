<?php

// TODO: Convert this to the new stuff.


class CWServiceTicketApiAPI extends ConnectWisePSA_SDK
{
    function __construct($CW_ROOT_DOMAIN="", $CW_COMPANY="", $CW_INTEGREATOR_USERNAME="", $CW_INTEGREATOR_PASSWORD="")
    {
        parent::__construct($CW_ROOT_DOMAIN, $CW_COMPANY, $CW_INTEGREATOR_USERNAME, $CW_INTEGREATOR_PASSWORD);
        $this->TheAPIType = 'ServiceTicketApi';
    }
    
    public function FindServiceTickets($params=array())
    {
        
        $params2['credentials'] = $this->credentials;
        if($params['conditions'] != '') { $params2['conditions'] = $params['conditions']; }
        if($params['orderBy'] != '') { $params2['orderBy'] = $params['orderBy']; }
        $params2['limit'] = round($params['limit']);
        $params2['skip'] = round($params['skip']);
        
        try
        {
            $results = $this->Call('FindServiceTickets', $params2);
            if(is_soap_fault($results)) { throw $results; }
            return $results->FindServiceTicketsResult->Ticket;
        }
        catch(SoapFault $fault) { return $fault;  }
    }
    
    public function AddServiceTicketViaCompanyId($params=array())
    {
        
        $params2['credentials'] = $this->credentials;
        $params2['companyId'] = round($params['companyId']);
        $params2['serviceTicket'] = $params['serviceTicket'];
        
        try
        {
            $results = $this->Call('AddServiceTicketViaCompanyId', $params2);
            if(is_soap_fault($results)) { throw $results; }
            return $results;
        }
        catch(SoapFault $fault) { return $fault;  }
    }
}


