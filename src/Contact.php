<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use LabtechSoftware\ConnectwisePsaSdk\Support\ApiException,
    LabtechSoftware\ConnectwisePsaSdk\Support\ConnectWiseBase;

/**
 * ConnectWise Contact API
 *
 * @package ConnectwisePsaSdk
 * @see LabtechSoftware\ConnectwisePsaSdk\Support\ConnectWiseBase
 */
class Contact extends ConnectWiseBase
{
    /**
     * Adds a contact to a specified group
     *
     * @todo Need a valid group id to finish testing this
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $contactId
     * @param int $groupId
     * @param string $note
     * @return array
     */
    public function addContactToGroup($contactId, $groupId, $note = '')
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        if (is_numeric($groupId) === false) {
            throw new ApiException('Group ID must be numeric.');
        }

        if (is_string($note) === false) {
            throw new ApiException('Note must be a string.');
        }

        $params = array(
            'contactID'       => $contactId,
            'groupID'         => $groupId,
            'transactionNote' => $note
        );

        return parent::getConnection()->makeRequest('AddContactToGroup', $params);
    }
    
    /**
     * Adds or updates a contact
     * Set RecId & Id to 0 to add new contact. 
     * If non-zero, the existing contact with that Id is updated.
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param array $contactData
     * @return array
     */
    public function addOrUpdateContact(array $contactData)
    {
        $params = array('contact' => $contactData);

        return parent::getConnection()->makeRequest('AddOrUpdateContact', $params);
    }
    
    /**
     * Adds or updates a contact's communication item
     * If the communicationItem id (inside of $commItemData) is 0, the communication item is added. 
     * If non-zero, the existing communicationItem with that Id is updated.
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $contactId
     * @param array $commItemData
     * @return array
     */
    public function addOrUpdateContactCommunicationItem($contactId, array $commItemData)
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        $params = array(
            'contactId'     => $contactId,
            'ContactMethod' => $commItemData
        );

        return parent::getConnection()->makeRequest(
            'AddOrUpdateContactCommunicationItem',
            $params
        );
    }
    
    /**
     * Adds or updates a contact note. 
     * If the note Id is 0, and the contactId is set; the note is added. 
     * If non-zero, the existing note with that Id is updated.
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $contactId
     * @param array $note
     * @return array
     */
    public function addOrUpdateContactNote($contactId, array $note)
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        $params = array(
            'contactId' => $contactId,
            'note' => $note
        );

        return parent::getConnection()->makeRequest(
            'AddOrUpdateContactNote',
            $params
        );
    }


    /**
     * @todo DO NOT USE THIS METHOD!
     * @todo Disabled until CW fixes authentication issues
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     *
     * f/ Marc: 
     * This is a very dangerous method right now. You should not use this unless you know what it does.
     * I recommend if your trying to authenticate via portal password (FindContacts method)
     * @param array $params
     */
    public static function authenticate(array $params)
    {
        throw new ApiException('Authenticate method unavailable.');

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
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $limit
     * @param int $skip
     * @param string $orderBy
     * @param string $conditions
     * @return array
     */
    public function findContacts(
        $limit = 0,
        $skip = 0,
        $orderBy = '',
        $conditions = ''
    )
    {
        if (is_numeric($limit) === false) {
            throw new ApiException('Limit value must be numeric.');
        }

        if (is_numeric($skip) === false) {
            throw new ApiException('Skip value must be numeric.');
        }

        if (is_string($orderBy) === false) {
            throw new ApiException('Order by must be a string.');
        }

        if (is_string($conditions) === false) {
            throw new ApiException('Conditions must be a string.');
        }

        $params = array(
            'skip' => $skip,
            'conditions' => $conditions,
            'orderBy' => $orderBy
        );

        // only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        return parent::getConnection()->makeRequest('FindContacts', $params);
    }

    /**
     * Finds a count of available contacts by a set of conditions
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param string $conditions
     * @return array
     */
    public function findContactsCount($conditions = '')
    {
        if (is_string($conditions) === false) {
            throw new ApiException('Conditions must be a string.');
        }

        $params = array('conditions' => $conditions);

        return parent::getConnection()->makeRequest('FindContactsCount', $params);
    }
    
    /**
     * Gets all communication types and descriptions
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @return array
     */
    public function getAllCommunicationTypesAndDescriptions()
    {
        return parent::getConnection()->makeRequest(
            'GetAllCommunicationTypesAndDescription',
            array()
        );
    }
    
    /**
     * Gets all communication items for contact by database record id
     * If no contact exists with the given id, an empty array is returned
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $contactId
     * @return array
     */
    public function getAllContactCommunicationItems($contactId)
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        $params = array(
            'contactId' => $contactId
        );

        return parent::getConnection()->makeRequest(
            'GetAllContactCommunicationItems',
            $params
        );
    }
    
    /**
     * Gets all notes for contact by database record id. 
     * If no contact exists with the given id, an exception is thrown in CW
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $contactRecId
     * @return array
     */
    public function getAllContactNotes($contactRecId)
    {
        if (is_numeric($contactRecId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        $params = array('contactId' => $contactRecId);

        return parent::getConnection()->makeRequest('GetAllContactNotes', $params);
    }


    /**
     * Gets a contact by database id
     * If no contact exists with the given id, an exception is thrown in cw
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $id
     * @return array
     */
    public function getContact($id)
    {
        if (is_numeric($id) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        $params = array('id' => $id);

        return parent::getConnection()->makeRequest('GetContact', $params);
    }
    
    /**
     * Gets a communication item for contact by database record contactId
     * If no contact exists with the given id, an exception is thrown in CW
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $contactId
     * @param string $type
     * @param string $description
     * @return array
     */
    public function getContactCommunicationItem($contactId, $type, $description = '')
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        if (is_string($type) === false) {
            throw new ApiException('Type must be a string.');
        }

        if (is_string($description) === false) {
            throw new ApiException('Description must be a string.');
        }

        $params = array(
            'contactId' => $contactId,
            'communicationType' => $type,
            'communicationDescription' => $description
        );

        return parent::getConnection()->makeRequest(
            'GetContactCommunicationItem',
            $params
        );
    }

    /**
     * Gets a note for contact by database record id
     * If no contact or contact note exists with the given ids, an exception is thrown in CW
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $contactId
     * @param int $noteId
     * @return array
     */
    public function getContactNote($contactId, $noteId)
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact id must be numeric.');
        }

        if (is_numeric($noteId) === false) {
            throw new ApiException('Note ID must be numeric.');
        }

        $params = array(
            'contactId' => $contactId,
            'noteId'    => $noteId
        );

        return parent::getConnection()->makeRequest('GetContactNote', $params);
    }
    
    /**
     * Return the configuration settings for the specified portal
     * An exception is thrown in CW if the portal is not found / doesn't exist
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param string $portalName
     * @return array
     */
    public function getPortalConfigSettings($portalName = '')
    {
        if (is_string($portalName) === false) {
            throw new ApiException('Portal name must be a string.');
        }

        $params = array('portalName' => $portalName);

        return parent::getConnection()->makeRequest(
            'GetPortalConfigSettings',
            $params
        );
    }
    
    /**
     * Get the login page customizations for the specified portal
     * Returns an empty array if portal is not found / doesn't exist
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param string $portalName
     * @return array
     */
    public function getPortalLoginCustomizations($portalName = '')
    {
        if (is_string($portalName) === false) {
            throw new ApiException('Portal name must be a string.');
        }

        $params = array('portalName' => $portalName);

        return parent::getConnection()->makeRequest(
            'GetPortalLoginCustomizations',
            $params
        );
    }
    
    /**
     * Return the security settings for the contact logged into the portal
     * This will always return an array of portal security settings regardless of what you send it
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $portalContId
     * @param string $portalCompName
     * @return array
     */
    public function getPortalSecurity($portalContId, $portalCompName = '')
    {
        if (is_numeric($portalContId) === false) {
            throw new ApiException('Portal ContId must be numeric.');
        }

        if (is_string($portalCompName) === false) {
            throw new ApiException('Portal name must be a string.');
        }

        $params = array(
            'portalContId' => $portalContId,
            'portalCompName' => $portalCompName
        );

        return parent::getConnection()->makeRequest('GetPortalSecurity', $params);
    }

    
    /**
     * Removes a contact from the specified group
     *
     * @todo Need a valid group id to finish testing this
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $contactId
     * @param int $groupId
     * @param string $note
     * @return array
     */
    public function removeContactFromGroup($contactId, $groupId, $note = '')
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        if (is_numeric($groupId) === false) {
            throw new ApiException('Group ID must be numeric.');
        }

        if (is_string($note) === false) {
            throw new ApiException('Note must be a string.');
        }

        $params = array(
            'contactID' => $contactId,
            'groupID' => $groupId,
            'transactionNote' => $note
        );

        return parent::getConnection()->makeRequest('RemoveContactFromGroup', $params);
    }
    
    /**
     * Runs the "Forgot Password" process on the server
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param string $emailAddress
     * @return array
     */
    public function requestPassword($emailAddress = '')
    {
        if (is_string($emailAddress) === false) {
            throw new ApiException('Email address must be a string.');
        }

        $params = array('emailAddress' => $emailAddress);

        return parent::getConnection()->makeRequest('RequestPassword', $params);
    }
    
    /**
     * Sets the default communication item 
     * Sets for: contactId, communcation type, and communication description
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $contactId
     * @param string $communicationType
     * @param string $communicationDescription
     * @return array
     */
    public function setDefaultContactCommunicationItem(
        $contactId,
        $communicationType,
        $communicationDescription
    )
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        if (is_string($communicationType) === false) {
            throw new ApiException('Communication type must be a string.');
        }

        if (is_string($communicationDescription) === false) {
            throw new ApiException('Communication description must be a string.');
        }

        $params = array(
            'contactId' => $contactId,
            'communicationType' => $communicationType,
            'communicationDescription' => $communicationDescription
        );

        return parent::getConnection()->makeRequest(
            'SetDefaultContactCommunicationItem',
            $params
        );
    }

    /**
     * Deletes a contact by database record id
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $id
     * @return array
     */
    public function deleteContact($id)
    {
        if (is_numeric($id) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        $params = array('id' => $id);

        return parent::getConnection()->makeRequest('DeleteContact', $params);
    }
    
    /**
     * Deletes a communication by database record 
     * Deletes for contactId, communcationType, and communicationDescription
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException 
     * @param int $contactId
     * @param string $type
     * @param string $description
     * @return array
     */
    public function deleteContactCommunicationItem(
        $contactId,
        $type,
        $description = ''
    )
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        if (is_string($type) === false) {
            throw new ApiException('Type must be a string.');
        }

        if (is_string($description) === false) {
            throw new ApiException('Description must be a string.');
        }

        $params = array(
            'contactId' => $contactId,
            'communicationType' => $type,
            'communicationDescription' => $description
        );

        return parent::getConnection()->makeRequest(
            'DeleteContactCommunicationItem',
            $params
        );
    }
    
    /**
     * Deletes a note by database record id. Returns an empty array on success
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $noteId
     * @param int $contactId
     * @return array
     */
    public function deleteNote($noteId, $contactId)
    {
        if (is_numeric($contactId) === false) {
            throw new ApiException('Contact ID must be numeric.');
        }

        if (is_numeric($noteId) === false) {
            throw new ApiException('Note ID must be numeric.');
        }

        $params = array(
            'id' => $noteId,
            'contactId' => $contactId
        );

        return parent::getConnection()->makeRequest('DeleteNote', $params);
    }
}