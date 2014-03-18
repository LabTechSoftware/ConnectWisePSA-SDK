<?php

use LabtechSoftware\ConnectwisePsaSdk\SoapApiRequester;
use LabtechSoftware\ConnectwisePsaSdk\Contact;

class ContactIntegrationTest extends PHPUnit_Framework_TestCase
{
    protected $fixture;

    protected function setUp()
    {
        $configLoader = $this->getMockBuilder('LabtechSoftware\ConnectwisePsaSdk\ConfigLoader')
            ->disableOriginalConstructor()
            ->getMock();

        $configLoader->expects($this->any())
            ->method('getSoapCredentials')
            ->will($this->returnValue(array(
                        'CompanyId' => 'LabTech',
                        'IntegratorLoginId' => 'webdev',
                        'IntegratorPassword' => 'webdev'
                    )));

        $soap = new SoapClient(
            'http://test.connectwise.com/v4_6_release/apis/1.5/ContactAPI.asmx?wsdl',
            array(
                'soap_version' => SOAP_1_1,
                'exception' => true,
                'trace' => 1,
                'cache_wsdl' => WSDL_CACHE_NONE
            )
        );

        $client = new SoapApiRequester($soap, $configLoader);

        $this->fixture = new Contact($client);
    }


    public function testAddContact()
    {
        $params = array(
            'ManagerID' => 0,
            'AssistantID' => 0,
            'ContactRecID' => 0,
            'Id' => 0,
            'Gender' => 'Male',
            'BirthDay' => '2008-01-07T00:00:00-05:00',
            'Married' => false,
            'Children' => false,
            'Anniversary' => '2008-01-07T00:00:00-05:00',
            'PortalSecurityLevel' => 1,
            'DisablePortalLogin' => true,
            'Inactive' => true,
            'UnsubscribeFlag' => true,
            'LastUpdate' => '2008-01-07T00:00:00-05:00',
            'PersonalAddressFlag' => true,
            'FirstName' => 'Jimmy Joneszzaaz'
        );

        $contact = $this->fixture->addOrUpdateContact($params);

        $this->assertInternalType('object', $contact);

        return $contact->AddOrUpdateContactResult->Id;
    }


    /**
     * @depends testAddContact
     */
    public function testUpdateContact($contactID)
    {
        $params = array(
            'ManagerID' => 0,
            'AssistantID' => 0,
            'ContactRecID' => 0,
            'Id' => $contactID,
            'Gender' => 'Female',
            'BirthDay' => '2008-01-07T00:00:00-05:00',
            'Married' => false,
            'Children' => false,
            'Anniversary' => '2008-01-07T00:00:00-05:00',
            'PortalSecurityLevel' => 1,
            'DisablePortalLogin' => true,
            'Inactive' => true,
            'UnsubscribeFlag' => true,
            'LastUpdate' => '2008-01-07T00:00:00-05:00',
            'PersonalAddressFlag' => true,
            'FirstName' => 'Jimmy Joneszzaaz'
        );

        $contact = $this->fixture->addOrUpdateContact($params);

        $this->assertInternalType('object', $contact);
    }


    //todo: need that groupID bro
    /**
     * @depends testAddContact
     */
/*    public function testAddContactToGroup($contactID)
    {
        // need a way to pull group ids available, or create a group, in order to test this endpoint

        //$this->fixture->addContactToGroup($contactID, $groupID, $note);
    }*/


    public function testGetAllCommunicationTypesAndDescriptions()
    {
        $commTypesAndDescriptions = $this->fixture->getAllCommunicationTypesAndDescriptions();
        $this->assertInternalType('object', $commTypesAndDescriptions);
    }


    /**
     * @depends testAddContact
     */
    public function testAddOrUpdateContactCommunicationItem($contactID)
    {
        $commItemData = array(
            'Id'=> 0,
            'Type' => 'EmailAddress',
            'CommunicationTypeId' => 0,
            'Description' => 'Email',
            'Value' => 'jim.jones@gmail.com',
            'IsDefaultForType' => true
        );


        $commItem = $this->fixture->addOrUpdateContactCommunicationItem($contactID, $commItemData);

        $this->assertInternalType('object', $commItem);
    }


    /**
     * @depends testAddContact
     */
    public function testAddContactNote($contactID)
    {
        $noteData = array(
            'Id' => 0,
            'NoteType' => 'Comment',
            'NoteText' => 'Hello World',
            'IsFlagged' => false,
            'EnteredBy' => 'Josh Maun',
            'LastUpdatedBy' => '2008-01-07T00:00:00-05:00',
            'LastUpdatedOn' => '2007-01-07T00:00:00-05:00'

        );

        $note = $this->fixture->addOrUpdateContactNote($contactID, $noteData);
        $this->assertInternalType('object', $note);

        return $note->AddOrUpdateContactNoteResult->Id;
    }


    /**
     * @depends testAddContact
     * @depends testAddContactNote
     */
    public function testUpdateContactNote($contactID, $noteID)
    {
        $noteData = array(
            'Id' => $noteID,
            'NoteType' => 'Comment',
            'NoteText' => 'Hello World',
            'IsFlagged' => false,
            'EnteredBy' => 'Josh Maun',
            'LastUpdatedBy' => '2008-01-07T00:00:00-05:00',
            'LastUpdatedOn' => '2007-01-07T00:00:00-05:00'

        );

        $this->assertInternalType('object', $this->fixture->addOrUpdateContactNote($contactID, $noteData));
    }


    /**
     * @depends testAddContact
     */
    public function testFindContacts($contactID)
    {
        $conditions = 'ContactRecID = ' . $contactID;
        $this->assertInternalType('object', $this->fixture->findContacts(1, 0, '', $conditions));
    }


    public function testFindContactsCount()
    {
        $this->assertInternalType('object', $this->fixture->findContactsCount(''));
    }


    /**
     * @depends testAddContact
     */
    public function testGetAllContactCommunicationItems($contactID)
    {
        $this->assertInternalType('object', $this->fixture->getAllContactCommunicationItems($contactID));
    }


    /**
     * @depends testAddContact
     */
    public function testGetAllContactNotes($contactID)
    {
        $this->assertInternalType('object', $this->fixture->getAllContactNotes($contactID));
    }


    /**
     * @depends testAddContact
     */
    public function testGetContact($contactID)
    {
        $this->assertInternalType('object', $this->fixture->getContact($contactID));
    }


    /**
     * @depends testAddContact
     */
    public function testGetContactCommunicationItem($contactID)
    {
        $commItem = $this->fixture->getContactCommunicationItem($contactID, 'EmailAddress', 'Email');
        $this->assertInternalType('object', $commItem);
    }


    /**
     * @depends testAddContact
     * @depends testAddContactNote
     */
    public function testGetContactNote($contactID, $noteID)
    {
        $this->assertInternalType('object', $this->fixture->getContactNote($contactID, $noteID));
    }


    public function testGetPortalConfigSettings()
    {
        $this->assertInternalType('object', $this->fixture->getPortalConfigSettings('Default'));
    }


    public function testGetPortalLoginCustomizations()
    {
        $this->assertInternalType('object', $this->fixture->getPortalLoginCustomizations('Default'));
    }


    public function testGetPortalSecurity()
    {
        $this->assertInternalType('object', $this->fixture->getPortalSecurity(0, ''));
    }


    //todo: need that groupID bro
/*    public function testRemoveContactFromGroup()
    {
        $this->fixture->removeContactFromGroup($contactID, $groupID, $note);
    }*/


    public function testRequestPassword()
    {
        $this->assertInternalType('object', $this->fixture->requestPassword('jim.jones@gmail.com'));
    }


    /**
     * @depends testAddContact
     */
    public function testSetDefaultContactCommunicationItem($contactID)
    {
        $commItem = $this->fixture->setDefaultContactCommunicationItem($contactID, 'EmailAddress', 'Email');
        $this->assertInternalType('object', $commItem);
    }


    /**
     * @depends testAddContact
     */
    public function testDeleteContactCommunicationItem($contactID)
    {
        $commItem = $this->fixture->deleteContactCommunicationItem($contactID, 'EmailAddress', 'Email');
        $this->assertInternalType('object', $commItem);
    }


    /**
     * @depends testAddContact
     * @depends testAddContactNote
     */
    public function testDeleteNote($contactID, $noteID)
    {
        $this->assertInternalType('object', $this->fixture->deleteNote($noteID, $contactID));
    }


    /**
     * @depends testAddContact
     */
    public function testDeleteContact($contactID)
    {
        $this->assertInternalType('object', $this->fixture->deleteContact($contactID));
    }
}
