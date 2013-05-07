<?php namespace Api\ConnectWise;

use Api\ApiResource,
    Api\ApiRequestParams,
    Api\ApiResult,
    Api\ApiException;

class Contact
{
    protected static $currentApi = 'ContactAPI';
    
    /**
     * @todo test
     */
    public static function addContactToGroup($contactId, $groupId, $note = '')
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        if (is_int($groupId) === false)
        {
            throw new ApiException('Group ID must be an integer.');
        }

        ApiRequestParams::set('contactID', $contactId);
        ApiRequestParams::set('groupID', $groupId);
        ApiRequestParams::set('transactionNote', $note);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddContactToGroup(ApiRequestParams::getAll());

        ApiResult::addResult($results->AddContactToGroupResult);

        return ApiResult::getAll();
    }
    
    /**
     * @todo test
     */
    public static function addOrUpdateContact(array $contact)
    {
        ApiRequestParams::set('contact', $contact);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddOrUpdateContact(ApiRequestParams::getAll());

        ApiResult::addResult($results->AddOrUpdateContactResult);

        return ApiResult::getAll();
    }
    
    /**
     * @todo test
     */
    public static function addOrUpdateContactCommunicationItem($contactId, array $method)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('ContactMethod', $method);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddOrUpdateContactCommunicationItem(ApiRequestParams::getAll());

        ApiResult::addResult($results->AddOrUpdateContactCommunicationItemResult);

        return ApiResult::getAll();
    }
    
    /**
     * @todo test
     */
    public static function addOrUpdateContactNote($contactId, array $note)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('note', $note);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddOrUpdateContactNote(ApiRequestParams::getAll());

        ApiResult::addResult($results->AddOrUpdateContactNoteResult);

        return ApiResult::getAll();
    }

    /**
     * This is a very dangerous method right now. You should not use this unless you know what it does.
     * I reccomend if your trying to authenticate via portal password you use the FindContacts method
     * @param array $params email, loginpw and portalName please.
     */
    /*
    public static function authenticate($params=array())
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
    */
    
    public static function findCompanies($limit = 0, $skip = 0, $orderBy = null, $conditions = null)
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

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->FindCompanies(ApiRequestParams::getAll());

        if (method_exists($results->FindCompaniesResult, 'ContactFindResult') === true)
        {
            ApiResult::addResult($results->FindCompaniesResult->ContactFindResult);
        }
        elseif (property_exists($results->FindCompaniesResult, 'ContactFindResult') === true)
        {
            ApiResult::addResult($results->FindCompaniesResult->ContactFindResult);
        }
        else
        {
            ApiResult::addResult($results->FindCompaniesResult);
        }

        return ApiResult::getAll();
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

        if (method_exists($findResults->FindContactsResult, 'ContactFindResult') === true)
        {
            ApiResult::addResult($findResults->FindContactsResult->ContactFindResult);
        }
        elseif (property_exists($findResults->FindContactsResult, 'ContactFindResult') === true)
        {
            ApiResult::addResult($findResults->FindContactsResult->ContactFindResult);
        }
        else
        {
            ApiResult::addResult($findResults->FindContactsResult);
        }

        return ApiResult::getAll();
    }
    
    public static function findContactsCount($conditions = null)
    {
        ApiRequestParams::set('conditions', $conditions);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->FindContactsCount(ApiRequestParams::getAll());

        ApiResult::addResult($results->FindContactsCountResult);

        return ApiResult::getAll();
    }
    
    public static function getAllCommunicationTypesAndDescriptions()
    {
        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetAllCommunicationTypesAndDescription(ApiRequestParams::getAll());

        if (method_exists($results->GetAllCommunicationTypesAndDescriptionResult, 'CommunicationTypeDescriptions') === true)
        {
            ApiResult::addResult($results->GetAllCommunicationTypesAndDescriptionResult->CommunicationTypeDescriptions);    
        }
        elseif (property_exists($results->GetAllCommunicationTypesAndDescriptionResult, 'CommunicationTypeDescriptions') === true)
        {
            ApiResult::addResult($results->GetAllCommunicationTypesAndDescriptionResult->CommunicationTypeDescriptions);
        }
        else
        {
            ApiResult::addResult($results->GetAllCommunicationTypesAndDescriptionResult);
        }

        return ApiResult::getAll();
    }
    
    public static function getAllContactCommunicationItems($contactId)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetAllContactCommunicationItems(ApiRequestParams::getAll());

        if (method_exists($results->GetAllContactCommunicationItemsResult, 'ContactCommunicationItem') === true)
        {
            ApiResult::addResult($results->GetAllContactCommunicationItemsResult->ContactCommunicationItem);    
        }
        elseif (property_exists($results->GetAllContactCommunicationItemsResult, 'ContactCommunicationItem') === true)
        {
            ApiResult::addResult($results->GetAllContactCommunicationItemsResult->ContactCommunicationItem);
        }
        else
        {
            ApiResult::addResult($results->GetAllContactCommunicationItemsResult);
        }

        return ApiResult::getAll();
    }
    
    public static function getAllContactNotes($contactId)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetAllContactNotes(ApiRequestParams::getAll());

        if (method_exists($results->GetAllContactNotesResult, 'ContactNote') === true)
        {
            ApiResult::addResult($results->GetAllContactNotesResult->ContactNote);    
        }
        elseif (property_exists($results->GetAllContactNotesResult, 'ContactNote') === true)
        {
            ApiResult::addResult($results->GetAllContactNotesResult->ContactNote);
        }
        else
        {
            ApiResult::addResult($results->GetAllContactNotesResult);
        }

        return ApiResult::getAll();
    }
    
    /**
     * @todo test (need a valid image id)
     */
    public static function getAvatarImage($imageId)
    {
        if (is_int($imageId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('imageId', $imageId);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetAvatarImage(ApiRequestParams::getAll());

        ApiResult::addResult($results->GetAvatarImageResult);

        return ApiResult::getAll();
    }
    
    public static function getByRecId($recId)
    {
        if (is_int($recId) === false)
        {
            throw new ApiException('RecID must be an integer.');
        }

        ApiRequestParams::set('id', $recId);

        $getResults = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetContact(ApiRequestParams::getAll());

        $evalResults = (round($getResults->GetContactResult->ContactRecID) > 0) ? $getResults->GetContactResult : array();

        ApiResult::addResult($evalResults);

        return ApiResult::getAll();
    }

    public static function getContact($contactId)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('id', $contactId);

        $getResults = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetContact(ApiRequestParams::getAll());

        ApiResult::addResult($getResults->GetContactResult);

        return ApiResult::getAll();
    }
    
    public static function getContactCommunicationItem($contactId, $type, $description)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('communicationType', $type);
        ApiRequestParams::set('communicationDescription', $description);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetContactCommunicationItem(ApiRequestParams::getAll());

        if (method_exists($results, 'ContactMethod') === true)
        {
            ApiResult::addResult($results->ContactMethod);    
        }
        elseif (property_exists($results, 'ContactMethod') === true)
        {
            ApiResult::addResult($results->ContactMethod);
        }
        else
        {
            ApiResult::addResult($results);
        }

        return ApiResult::getAll();
    }
    
    ////// stopping point - azavala 5/7 ///////

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

    /**
     * @todo test
     */
    public static function deleteContact($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->DeleteContact(ApiRequestParams::getAll());

        ApiResult::addResult($results->DeleteContactResult);

        return ApiResult::getAll();
    }
    
    /**
     * @todo test
     */
    public static function deleteContactCommunicationItem($contactId, $type, $description = '')
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('communicationType', $type);
        ApiRequestParams::set('communicationDescription', $description);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->DeleteContactCommunicationItem(ApiRequestParams::getAll());

        ApiResult::addResult($results->DeleteContactCommunicationItemResult);

        return ApiResult::getAll();
    }
    
    /**
     * @todo test
     */
    public static function deleteNote($noteId, $contactId)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        if (is_int($noteId) === false)
        {
            throw new ApiException('Note ID must be an integer.');
        }

        ApiRequestParams::set('id', $noteId);
        ApiRequestParams::set('contactId', $contactId);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->DeleteNote(ApiRequestParams::getAll());

        ApiResult::addResult($results->DeleteNoteResult);

        return ApiResult::getAll();
    }
}