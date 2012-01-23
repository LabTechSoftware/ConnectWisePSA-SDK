<?php


class CWReportingAPI extends ConnectWisePSA_SDK
{
    function __construct($CW_ROOT_DOMAIN="", $CW_COMPANY="", $CW_INTEGREATOR_USERNAME="", $CW_INTEGREATOR_PASSWORD="")
    {
        parent::__construct($CW_ROOT_DOMAIN, $CW_COMPANY, $CW_INTEGREATOR_USERNAME, $CW_INTEGREATOR_PASSWORD);
        $this->TheAPIType = 'ReportingAPI';
    }
    
    public function GetPortalReports()
    {
        // NOT IMPLIMENTED YET
    }
    
    public function GetReportFields($reportName)
    {
        // NOT IMPLIMENTED YET
    }
    
    public function GetReports($includeFields=TRUE)
    {
        $params2['credentials'] = $this->credentials;
        $params2['includeFields'] = $includeFields == FALSE ? FALSE : TRUE;
        
        try
        {
            $results = $this->Call('GetReports', $params2);
            if(is_soap_fault($results)) { throw $results; }
            return $results->GetReportsResult->Report;
        }
        catch(SoapFault $fault) { return $fault;  }
    }
    
    public function RunPortalReport($reportName, $conditions="", $orderBy="", $limit=100, $skip=0)
    {
        // NOT IMPLIMENTED YET
    }
    public function RunReportCount($reportName, $conditions="")
    {
        // NOT IMPLIMENTED YET
    }
    
    public function RunReportQuery($reportName, $conditions="", $orderBy="", $limit=100, $skip=0)
    {
        $params2['credentials'] = $this->credentials;
        $params2['reportName'] = $reportName;
        if($conditions != '') { $params2['conditions'] = $conditions; }
        if($orderBy != '') { $params2['orderBy'] = $orderBy; }
        $params2['limit'] = $limit;
        $params2['skip'] = $skip;
        
        try
        {
            $results = $this->Call('RunReportQuery', $params2);
            if(is_soap_fault($results)) { throw $results; }
            return $results->RunReportQueryResult->ResultRow;
        }
        catch(SoapFault $fault) { return $fault;  }
    }
}