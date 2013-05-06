<?php namespace Api\ConnectWise;

use Api\ApiResource,
    Api\ApiRequestParams,
    Api\ApiResult,
    Api\ApiException;

class Contact
{
    protected static $currentApi = 'ContactAPI';
    
    public static function addContactToGroup()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function addOrUpdateContact()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function addOrUpdateContactCommunicationItem()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function addOrUpdateContactNote()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    /**
     * This is a very dangerous method right now. You should not use this unless you know what it does.
     * I reccomend if your trying to authenticate via portal password you use the FindContacts method
     * @param array $params email, loginpw and portalName please.
     */
    public static function authenticate($params=array())
    {
        /*
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
        */
    }
    
    public static function deleteContact()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function deleteContactCommunicationItem()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function deleteNote()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function findCompanies()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    /**
     * Finds contact information by a set of conditions
     *
     * @param integer $limit      Limits the number of results a query should return
     * @param integer $skip       How many to skip, good for pagination
     * @param string  $conditions [description]
     * @param string  $orderBy    Which property to sort by.
     */
    public static function findContacts($limit = 0, $skip = 0, $orderBy = null, $conditions = null)
    {
        if (is_int($limit) === false)
        {
            throw new ApiException('Limit value must be an integer.');
        }

        if (is_int($skip) === false)
        {
            throw new ApiException('Skip value must be an integer.');
        }

        ApiRequestParams::set('limit', $limit);
        ApiRequestParams::set('skip', $skip);
        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('orderBy', $orderBy);

        $findResults = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->FindContacts(ApiRequestParams::getAll());

        ApiResult::addResult($findResults->FindContactsResult->ContactFindResult);

        return ApiResult::getAll();
    }
    
    public static function findContactsCount()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    // WTF?
    public static function getAllCommunicationTypesAndDescription()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function getAllContactCommunicationItems()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function getAllContactNotes()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function getAvatarImage()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function getByRecId($recId)
    {
        ApiRequestParams::set('id', $recId);

        $getResults = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetContact(ApiRequestParams::getAll());

        $evalResults = (round($getResults->GetContactResult->ContactRecID) > 0) ? $getResults->GetContactResult : false;

        ApiResult::addResult($evalResults);

        return ApiResult::getAll();
    }
    
    public static function getContactCommunicationItem()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function getContactNote()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function getPortalConfigSettings()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function getPortalLoginCustomizations()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function getPortalSecurity()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function loadContact()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function removeContactFromGroup()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function requestPassword()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
    
    public static function setDefaultContactCommunicationItem()
    {
        // NOT IMPLIMENTED YET
        throw new ApiExceptions(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
}