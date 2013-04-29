<?php namespace ConnectWisePSA;


class ReportingAPI extends ConnectWisePSABase
{
    function __construct()
    {
        parent::__construct();
        $this->CurrentAPI = 'ReportingAPI';
    }
    
    public function GetPortalReports()
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetReportFields($reportName)
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function GetReports($includeFields=TRUE)
    {
        $params['credentials'] = $this->credentials;
        $params['includeFields'] = $includeFields == FALSE ? FALSE : TRUE;
        
        try
        {
            $results = $this->call('GetReports', $params);
            if(is_soap_fault($results)) { throw $results; }
            return $results->GetReportsResult->Report;
        }
        catch(SoapFault $fault) { return $fault;  }
    }
    
    public function RunPortalReport($reportName, $conditions="", $orderBy="", $limit=100, $skip=0)
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    public function RunReportCount($reportName, $conditions="")
    {
        // NOT IMPLIMENTED YET
        throw new ConnectWisePSAException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public function RunReportQuery($reportName, $conditions="", $orderBy="", $limit=100, $skip=0)
    {
        $params['credentials'] = $this->credentials;
        $params['reportName'] = $reportName;
        if($conditions != '') { $params['conditions'] = $conditions; }
        if($orderBy != '') { $params['orderBy'] = $orderBy; }
        $params['limit'] = $limit;
        $params['skip'] = $skip;
        
        try
        {
            $results = $this->call('RunReportQuery', $params);
            if(is_soap_fault($results)) { throw $results; }
            return $results->RunReportQueryResult->ResultRow;
        }
        catch(SoapFault $fault) { return $fault;  }
    }
}