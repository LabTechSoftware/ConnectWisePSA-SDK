<?php namespace ConnectWiseApi;

use ConnectWiseApi\ApiResource,
    ConnectWiseApi\ApiRequestParams,
    ConnectWiseApi\ApiResult,
    ConnectWiseApi\ApiException;

class Contact
{
    /**
     * The API name for the SOAP connection
     *
     * @var string
     */
    protected static $currentApi = 'ContactAPI';
    
    /**
     * Adds a contact to a specified group
     *
     * @todo Need a valid group id to finish testing this
     *
     * @throws ApiException
     * @param integer $contactId
     * @param integer $groupId
     * @param string $note
     * @return mixed
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

        ApiResult::addResultFromObject($results, 'AddContactToGroupResult');

        return ApiResult::getAll();
    }
    
    /**
     * Adds or updates a contact
     * Set RecId & Id to 0 to add new contact. If non-zero, the existing contact with that Id is updated.
     *
     * @param array $contactData
     * @return mixed
     */
    public static function addOrUpdateContact(array $contactData)
    {
        ApiRequestParams::set('contact', $contactData);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddOrUpdateContact(ApiRequestParams::getAll());

        ApiResult::addResultFromObject($results, 'AddOrUpdateContactResult');

        return ApiResult::getAll();
    }
    
    /**
     * Adds or updates a contact's communication item
     * If the communicationItem id (inside of $commItemData) is 0, the communication item is added. 
     * If non-zero, the existing communicationItem with that Id is updated.
     *
     * @throws ApiException
     * @param integer $contactId
     * @param array $method
     * @return mixed
     */
    public static function addOrUpdateContactCommunicationItem($contactId, array $commItemData)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('ContactMethod', $commItemData);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddOrUpdateContactCommunicationItem(ApiRequestParams::getAll());

        ApiResult::addResultFromObject($results, 'AddOrUpdateContactCommunicationItemResult');

        return ApiResult::getAll();
    }
    
    /**
     * Adds or updates a contact note. 
     * If the note Id is 0, and the contactId is set; the note is added. 
     * If non-zero, the existing note with that Id is updated.
     *
     * @throws ApiException
     * @param integer $contactId
     * @param array $note
     * @return mixed
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

        ApiResult::addResultFromObject($results, 'AddOrUpdateContactNoteResult');

        return ApiResult::getAll();
    }

    /**
     * @todo Disabled until CW fixes authentication issues -- DO NOT USE THIS METHOD!
     * 
     * f/ Marc: 
     * This is a very dangerous method right now. You should not use this unless you know what it does.
     * I reccomend if your trying to authenticate via portal password you use the FindContacts method
     * @param array $params
     */
    public static function authenticate(array $params)
    {
        throw new ApiException('Authenticate method unvailable.');

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
    
    /**
     * Finds contact information by a set of conditions
     * 
     * @throws ApiException
     * @param integer $limit
     * @param integer $skip
     * @param string $orderBy
     * @param string $conditions
     * @return mixed
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

        ApiResult::addResultFromObject($results->FindCompaniesResult, 'ContactFindResult');

        return ApiResult::getAll();
    }
    
    /**
     * Finds contact information by a set of conditions
     *
     * @throws ApiException
     * @param integer $limit
     * @param integer $skip
     * @param string $orderBy
     * @param string $conditions
     * @return mixed
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

        ApiResult::addResultFromObject($findResults->FindContactsResult, 'ContactFindResult');

        return ApiResult::getAll();
    }
    
    // --- stopping point - azavala 3/9/13 ---

    /**
     * @todo test
     */
    public static function findContactsCount($conditions = null)
    {
        ApiRequestParams::set('conditions', $conditions);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->FindContactsCount(ApiRequestParams::getAll());

        ApiResult::addResult($results->FindContactsCountResult);

        return ApiResult::getAll();
    }
    
    /**
     * @todo test
     */
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
    
    /**
     * @todo test
     */
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
    
    /**
     * Gets all notes for contact by database record id. 
     * If no contact exists with the given id, an empty array is returned
     *
     * @throws ApiException
     * @param integer $contactId
     * @return array
     */
    public static function getAllContactNotes($contactId)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetAllContactNotes(ApiRequestParams::getAll());

        ApiResult::addResultFromObject($results->GetAllContactNotesResult, 'ContactNote');

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
    
    /**
     * Alias of getContact
     *
     * @see getContact()
     */
    public static function getContactByRecId($recId)
    {
        return static::getContact($recId);
    }

    /**
     * Gets a contact by database record id ("rec id"). 
     * If no contact exists with the given id, an empty array is returned
     *
     * @throws ApiException
     * @param integer $contactRecId
     * @return mixed
     */
    public static function getContact($contactRecId)
    {
        if (is_int($contactRecId) === false)
        {
            throw new ApiException('Contact Rec ID must be an integer.');
        }

        ApiRequestParams::set('id', $contactRecId);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetContact(ApiRequestParams::getAll());

        ApiResult::addResultFromObject($results, 'GetContactResult');

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