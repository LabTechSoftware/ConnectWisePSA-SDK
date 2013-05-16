<?php namespace ConnectWiseApi;

use SoapFault,
    ConnectWiseApi\ApiResource,
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
     * @return array
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

        if (is_string($note) === false)
        {
            throw new ApiException('Note must be a string.');
        }

        ApiRequestParams::set('contactID', $contactId);
        ApiRequestParams::set('groupID', $groupId);
        ApiRequestParams::set('transactionNote', $note);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddContactToGroup(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddContactToGroupResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Adds or updates a contact
     * Set RecId & Id to 0 to add new contact. If non-zero, the existing contact with that Id is updated.
     *
     * @throws ApiException
     * @param array $contactData
     * @return array
     */
    public static function addOrUpdateContact(array $contactData)
    {
        ApiRequestParams::set('contact', $contactData);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddOrUpdateContact(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddOrUpdateContactResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Adds or updates a contact's communication item
     * If the communicationItem id (inside of $commItemData) is 0, the communication item is added. 
     * If non-zero, the existing communicationItem with that Id is updated.
     *
     * @throws ApiException
     * @param integer $contactId
     * @param array $method
     * @return array
     */
    public static function addOrUpdateContactCommunicationItem($contactId, array $commItemData)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('ContactMethod', $commItemData);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddOrUpdateContactCommunicationItem(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'ContactMethod');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Adds or updates a contact note. 
     * If the note Id is 0, and the contactId is set; the note is added. 
     * If non-zero, the existing note with that Id is updated.
     *
     * @throws ApiException
     * @param integer $contactId
     * @param array $note
     * @return array
     */
    public static function addOrUpdateContactNote($contactId, array $note)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('note', $note);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddOrUpdateContactNote(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddOrUpdateContactNoteResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * @todo Disabled until CW fixes authentication issues -- DO NOT USE THIS METHOD!
     * @throws ApiException
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
     * @return array
     */
    public static function findCompanies($limit = 0, $skip = 0, $orderBy = '', $conditions = '')
    {
        if (is_int($limit) === false)
        {
            throw new ApiException('Limit value must be an integer.');
        }

        if (is_int($skip) === false)
        {
            throw new ApiException('Skip value must be an integer.');
        }

        if (is_string($orderBy) === false)
        {
            throw new ApiException('Order by must be a string.');
        }

        if (is_string($conditions) === false)
        {
            throw new ApiException('Conditions must be a string.');
        }

        ApiRequestParams::set('limit', $limit);
        ApiRequestParams::set('skip', $skip);
        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('orderBy', $orderBy);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->FindCompanies(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->FindCompaniesResult, 'ContactFindResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Finds contact information by a set of conditions
     *
     * @throws ApiException
     * @param integer $limit
     * @param integer $skip
     * @param string $orderBy
     * @param string $conditions
     * @return array
     */
    public static function findContacts($limit = 0, $skip = 0, $orderBy = '', $conditions = '')
    {
        if (is_int($limit) === false)
        {
            throw new ApiException('Limit value must be an integer.');
        }

        if (is_int($skip) === false)
        {
            throw new ApiException('Skip value must be an integer.');
        }

        if (is_string($orderBy) === false)
        {
            throw new ApiException('Order by must be a string.');
        }

        if (is_string($conditions) === false)
        {
            throw new ApiException('Conditions must be a string.');
        }

        ApiRequestParams::set('limit', $limit);
        ApiRequestParams::set('skip', $skip);
        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('orderBy', $orderBy);

        try
        {
            $findResults = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->FindContacts(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($findResults->FindContactsResult, 'ContactFindResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Finds a count of available contacts by a set of conditions
     *
     * @throws ApiException
     * @param string $conditions
     * @return array
     */
    public static function findContactsCount($conditions = '')
    {
        if (is_string($conditions) === false)
        {
            throw new ApiException('Conditions must be a string.');
        }

        ApiRequestParams::set('conditions', $conditions);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->FindContactsCount(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'FindContactsCountResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Gets all communication types and descriptions
     *
     * @throws ApiException
     * @return array
     */
    public static function getAllCommunicationTypesAndDescriptions()
    {
        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetAllCommunicationTypesAndDescription(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->GetAllCommunicationTypesAndDescriptionResult, 'CommunicationTypeDescriptions');
            
            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Gets all communication items for contact by database record id
     * If no contact exists with the given id, an empty array is returned
     *
     * @throws ApiException
     * @param integer $contactId
     * @return array
     */
    public static function getAllContactCommunicationItems($contactId)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetAllContactCommunicationItems(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->GetAllContactCommunicationItemsResult, 'ContactCommunicationItem');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Gets all notes for contact by database record id. 
     * If no contact exists with the given id, an exception is thrown in CW
     *
     * @throws ApiException
     * @param integer $contactId
     * @return array
     */
    public static function getAllContactNotes($contactRecId)
    {
        if (is_int($contactRecId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactRecId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetAllContactNotes(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->GetAllContactNotesResult, 'ContactNote');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Gets an avatar image from the server
     *
     * @todo need a valid image id to test
     * @throws ApiException
     * @param string $imageId
     * @return array
     */
    public static function getAvatarImage($imageId)
    {
        if (is_string($imageId) === false)
        {
            throw new ApiException('Avatar image id must be a string.');
        }

        ApiRequestParams::set('imageId', $imageId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetAvatarImage(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'GetAvatarImageResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Gets a contact by database id
     * If no contact exists with the given id, an exception is thrown in cw
     *
     * @throws ApiException
     * @param integer $id
     * @return array
     */
    public static function getContact($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetContact(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'GetContactResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Gets a communication item for contact by database record contactId
     * If no contact exists with the given id, an exception is thrown in CW
     *
     * @throws ApiException
     * @param integer $contactId
     * @param string $type
     * @param string $description
     * @return array
     */
    public static function getContactCommunicationItem($contactId, $type, $description = '')
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        if (is_string($type) === false)
        {
            throw new ApiException('Type must be a string.');
        }

        if (is_string($description) === false)
        {
            throw new ApiException('Description must be a string.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('communicationType', $type);
        ApiRequestParams::set('communicationDescription', $description);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetContactCommunicationItem(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'ContactMethod');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Gets a note for contact by database record id
     * If no contact or contact note exists with the given ids, an exception is thrown in CW
     *
     * @throws ApiException
     * @param integer $contactId
     * @param integer $noteId
     * @return array
     */
    public static function getContactNote($contactId, $noteId)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact id must be an integer.');
        }

        if (is_int($noteId) === false)
        {
            throw new ApiException('Note ID must be an integer.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('noteId', $noteId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetContactNote(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'GetContactNoteResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Return the configuration settings for the specified portal
     * An exception is thrown in CW if the portal is not found / doesn't exist
     *
     * @throws ApiException
     * @param string $portalName
     * @return array
     */
    public static function getPortalConfigSettings($portalName = '')
    {
        if (is_string($portalName) === false)
        {
            throw new ApiException('Portal name must be a string.');
        }

        ApiRequestParams::set('portalName', $portalName);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetPortalConfigSettings(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'GetPortalConfigSettingsResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Get the login page customizations for the specified portal
     * Returns an empty array if portal is not found / doesn't exist
     *
     * @throws ApiException
     * @param string $portalName
     * @return array
     */
    public static function getPortalLoginCustomizations($portalName = '')
    {
        if (is_string($portalName) === false)
        {
            throw new ApiException('Portal name must be a string.');
        }

        ApiRequestParams::set('portalName', $portalName);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetPortalLoginCustomizations(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'GetPortalLoginCustomizationsResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }   
    }
    
    /**
     * Return the security settings for the contact logged into the portal
     * This will always return an array of portal security settings regardless of what you send it
     *
     * @throws ApiException
     * @param integer $portalContId
     * @param string $portalCompName
     * @return array
     */
    public static function getPortalSecurity($portalContId, $portalCompName = '')
    {
        if (is_int($portalContId) === false)
        {
            throw new ApiException('Portal ContId must be an integer.');
        }

        if (is_string($portalCompName) === false)
        {
            throw new ApiException('Portal name must be a string.');
        }

        ApiRequestParams::set('portalContId', $portalContId);
        ApiRequestParams::set('portalCompName', $portalCompName);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetPortalSecurity(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->GetPortalSecurityResult, 'PortalSecurity');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Gets a contact by database record id
     * If no contact exists with the given id, an exception (SoapFault) is thrown
     *
     * @throws ApiException
     * @param integer $contactId
     * @return array
     */
    public static function loadContact($contactId)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('id', $contactId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->LoadContact(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'LoadContactResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Removes a contact from the specified group
     *
     * @todo Need a valid group id to finish testing this
     *
     * @throws ApiException
     * @param integer $contactId
     * @param integer $groupId
     * @param string $note
     * @return array 
     */
    public static function removeContactFromGroup($contactId, $groupId, $note = '')
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        if (is_int($groupId) === false)
        {
            throw new ApiException('Group ID must be an integer.');
        }

        if (is_string($note) === false)
        {
            throw new ApiException('Note must be a string.');
        }

        ApiRequestParams::set('contactID', $contactId);
        ApiRequestParams::set('groupID', $groupId);
        ApiRequestParams::set('transactionNote', $note);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->RemoveContactFromGroup(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'RemoveContactFromGroupResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Runs the "Forgot Password" process on the server
     *
     * @throws ApiException
     * @param string $emailAddress
     * @return array
     */
    public static function requestPassword($emailAddress = '')
    {
        if (is_string($emailAddress) === false)
        {
            throw new ApiException('Email address must be a string.');
        }

        ApiRequestParams::set('emailAddress', $emailAddress);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->RequestPassword(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results);

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Sets the default communication type for contactId, communcation type, and communication description
     *
     * @throws ApiException
     * @param integer $contactId
     * @param string $communicationType
     * @param string $communicationDescription
     * @return array
     */
    public static function setDefaultContactCommunicationItem($contactId, $communicationType, $communicationDescription)
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        if (is_string($communicationType) === false)
        {
            throw new ApiException('Communication type must be a string.');
        }

        if (is_string($communicationDescription) === false)
        {
            throw new ApiException('Communication description must be a string.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('communicationType', $communicationType);
        ApiRequestParams::set('communicationDescription', $communicationDescription);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->SetDefaultContactCommunicationItem(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'ContactMethod');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Deletes a contact by database record id
     *
     * @throws ApiException
     * @param integer $id
     * @return array
     */
    public static function deleteContact($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->DeleteContact(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results);

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Deletes a communication by database record for contactId, communcationType, and communicationDescription
     *
     * @throws ApiException 
     * @param integer $contactId
     * @param string $type
     * @param string $description
     * @return array
     */
    public static function deleteContactCommunicationItem($contactId, $type, $description = '')
    {
        if (is_int($contactId) === false)
        {
            throw new ApiException('Contact ID must be an integer.');
        }

        if (is_string($type) === false)
        {
            throw new ApiException('Type must be a string.');
        }

        if (is_string($description) === false)
        {
            throw new ApiException('Description must be a string.');
        }

        ApiRequestParams::set('contactId', $contactId);
        ApiRequestParams::set('communicationType', $type);
        ApiRequestParams::set('communicationDescription', $description);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->DeleteContactCommunicationItem(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results);

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
    
    /**
     * Deletes a note by database record id. Returns an empty array on success
     *
     * @throws ApiException
     * @param integer $noteId
     * @param integer $contactId
     * @return array
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

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->DeleteNote(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'DeleteNoteResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
}