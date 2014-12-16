<?php

use LabtechSoftware\ConnectwisePsaSdk\Contact;

/**
 * Tests for LabtechSoftware\ConnectwisePsaSdk\Contact
 *
 * @covers LabtechSoftware\ConnectwisePsaSdk\Contact
 */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Contact instance goes here
     *
     * @var LabtechSoftware\ConnectwisePsaSdk\Contact
     */
    protected $fixture;

    /**
     * New Contact instance for fixture
     * Also set a random string to use in tests
     */
    protected function setUp()
    {
        $client = $this->getMockBuilder('LabtechSoftware\ConnectwisePsaSdk\ConnectWiseApi')
            ->disableOriginalConstructor()
            ->getMock();

        $this->fixture = new Contact($client);
    }


    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::addContactToGroup
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testAddContactToGroupThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->addContactToGroup('not numeric', 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::addContactToGroup
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testAddContactToGroupThrowsExceptionWhenGroupIdIsNotNumeric()
    {
        $this->fixture->addContactToGroup(3, 'not numeric', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::addContactToGroup
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testAddContactToGroupThrowsExceptionWhenNoteIsNotString()
    {
        $this->fixture->addContactToGroup(3, 3, 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::addOrUpdateContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateContactCommunicationItemsThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->addOrUpdateContactCommunicationItem('not numeric', array());
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::addOrUpdateContactNote
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateContactNoteThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->addOrUpdateContactNote('not numeric', array());
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::authenticate
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testAuthenticateThrowsException()
    {
        $this->fixture->authenticate(array());
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::findContacts
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindContactsThrowsExceptionWhenLimitIsNotNumeric()
    {
        $this->fixture->findContacts('', 3, '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::findContacts
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindContactsThrowsExceptionWhenSkipIsNotNumeric()
    {
        $this->fixture->findContacts(3, '', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::findContacts
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindContactsThrowsExceptionWhenOrderByIsNotAString()
    {
        $this->fixture->findContacts(3, 3, 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::findContacts
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindContactsThrowsExceptionWhenConditionsIsNotAString()
    {
        $this->fixture->findContacts(3, 3, '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::findContactsCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindContactsCountThrowsExceptionWhenConditionsIsNotAString()
    {
        $this->fixture->findContactsCount(5);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getAllContactCommunicationItems
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetAllContactCommunicationItemsThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->getAllContactCommunicationItems('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getAllContactNotes
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetAllContactNotesThrowsExceptionWhenContactRecIdIsNotNumeric()
    {
        $this->fixture->getAllContactNotes('');
    }


    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getContact
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetContactThrowsExceptionWhenIdIsNotNumeric()
    {
        $this->fixture->getContact('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetContactCommunicationItemThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->getContactCommunicationItem('', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetContactCommunicationItemThrowsExceptionWhenTypeIsNotAString()
    {
        $this->fixture->getContactCommunicationItem(3, 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetContactCommunicationItemThrowsExceptoinWhenDescriptionIsNotAString()
    {
        $this->fixture->getContactCommunicationItem(3, '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getContactNote
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetContactNoteThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->getContactNote('', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getContactNote
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetContactNoteThrowsExceptionWhenNoteIdIsNotNumeric()
    {
        $this->fixture->getContactNote(3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getPortalConfigSettings
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetPortalConfigSettingsThrowsExceptionWhenPortalNameIsNotAString()
    {
        $this->fixture->getPortalConfigSettings(3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getPortalLoginCustomizations
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetPortalLoginCustomizationsThrowsExceptionWhenPortalNameIsNotAString()
    {
        $this->fixture->getPortalLoginCustomizations(3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getPortalSecurity
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetPortalSecurityThrowsExceptionWhenPortalContIdIsNotNumeric()
    {
        $this->fixture->getPortalSecurity('', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::getPortalSecurity
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetPortalSecurityThrowsExceptionWhenPortalCompNameIsNotAString()
    {
        $this->fixture->getPortalSecurity(3, 3);
    }


    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::removeContactFromGroup
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRemoveContactFromGroupThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->removeContactFromGroup('', 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::removeContactFromGroup
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRemoveContactFromGroupThrowsExceptionWhenGroupIdIsNotNumeric()
    {
        $this->fixture->removeContactFromGroup(3, '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::removeContactFromGroup
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRemoveContactFromGroupThrowsExceptionWhenNoteIsNotAString()
    {
        $this->fixture->removeContactFromGroup(3, 3, 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::requestPassword
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testRequestPasswordThrowsExceptionWhenEmailAddressIsNotAString()
    {
        $this->fixture->requestPassword(3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::setDefaultContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSetDefaultContactCommunicationItemThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->setDefaultContactCommunicationItem('', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::setDefaultContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSetDefaultContactCommunicationItemThrowsExceptionWhenCommunicationTypeIsNotAString()
    {
        $this->fixture->setDefaultContactCommunicationItem(3, 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::setDefaultContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSetDefaultContactCommunicationItemThrowsExceptionWhenCommunicationDescriptionIsNotAString()
    {
        $this->fixture->setDefaultContactCommunicationItem(3, '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::deleteContact
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteContactThrowsExceptionWhenIdIsNotNumeric()
    {
        $this->fixture->deleteContact('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::deleteContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteContactCommunicationItemThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->deleteContactCommunicationItem('', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::deleteContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteContactCommunicationItemThrowsExceptionWhenTypeIsNotAString()
    {
        $this->fixture->deleteContactCommunicationItem(3, 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::deleteContactCommunicationItem
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteContactCommunicationItemThrowsExceptionWhenDescriptionIsNotAString()
    {
        $this->fixture->deleteContactCommunicationItem(3, '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::deleteNote
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteNoteThrowsExceptionWhenNoteIdIsNotNumeric()
    {
        $this->fixture->deleteNote('', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Contact::deleteNote
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteNoteThrowsExceptionWhenContactIdIsNotNumeric()
    {
        $this->fixture->deleteNote(3, '');
    }
}
