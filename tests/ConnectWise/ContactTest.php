<?php

/**
 * Tests for \ConnectWiseApi\Contact
 *
 * @covers ConnectWiseApi\Contact
 */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    protected $fixture;
    protected $randomString;

    /**
     * New Contact instance for fixture
     */
    protected function setUp()
    {
        // Set class instance
        $this->fixture = new ConnectWiseApi\Contact;

        // Set a random string to use in tests
        $this->randomString = 'Test Entry num' . rand(10, 1000);
    }

    /**
     * @covers ConnectWiseApi\Contact
     */
    public function testCurrentApiNameExists()
    {
        $this->assertObjectHasAttribute('currentApi', $this->fixture);
    }

    /**
     * @covers ConnectWiseApi\Contact::addContactToGroup
     */
    /*
    public function testAddContactToGroupReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->addContactToGroup(2, 20, 'testing')));
    }
    */

    /**
     * @covers ConnectWiseApi\Contact::addContactToGroup
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testAddContactToGroupThrowsExceptionOnFail()
    {
        $this->fixture->addContactToGroup(2, 200, 'sdfsd');
    }

    /**
     * @covers ConnectWiseApi\Contact::addOrUpdateContact
     */
    public function testAddOrUpdateContactReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->addOrUpdateContact(array(
            'FirstName' => 'LTWebDevGuy', 'LastName' => 'Testerino', 'ContactRecID' => 0, 'Id' => 0,
            'BirthDay' => '0001-01-01T00:00:00', 'Married' => false, 'CompanyId' => 'ConnectWise',
            'Children' => false, 'Anniversary' => '0001-01-01T00:00:00', 'PortalSecurityLevel' => 6,
            'DisablePortalLogin' => false, 'Inactive' => false,
            'UnsubscribeFlag' => false, 'LastUpdate' => '2011-06-30T09:35:27.113', 'PersonalAddressFlag' => false,
            'Gender' => 'Male',
        ))));
    }

    /**
     * @covers ConnectWiseApi\Contact::addOrUpdateContact
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testAddOrUpdateContactThrowsExceptionWhenMissingRequiredInput()
    {
        $this->fixture->addOrUpdateContact(array(
            'FirstName' => 'LTWebDevGuy', 'LastName' => 'Testerino',
        ));
    }
    
    /**
     * @covers ConnectWiseApi\Contact::addOrUpdateContactCommunicationItem
     */
    public function testAddOrUpdateContactCommunicationItemReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->addOrUpdateContactCommunicationItem(2, array(
            'Id' => 0, 'Type' => 'PhoneNumber', 'CommunicationTypeId' => 0, 'Description' => 'Direct'
        ))));
    }

    /**
     * @covers ConnectWiseApi\Contact::addOrUpdateContactCommunicationItem
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testAddOrUpdateContactCommunicationItemThrowsExceptionOnFail()
    {
        $this->fixture->addOrUpdateContactCommunicationItem(0, array(
            'Description' => 'Testing...'
        ));
    }

    /**
     * @covers ConnectWiseApi\Contact::addOrUpdateContactNote
     */
    public function testAddOrUpdateContactNoteReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->addOrUpdateContactNote(2, array(
            'Id' => 0, 'NoteType' => 'Comment', 'NoteText' => 'Lorem ipsum', 'IsFlagged' => false
        ))));
    }

    /**
     * @covers ConnectWiseApi\Contact::addOrUpdateContactNote
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testAddOrUpdateContactNoteThrowsExceptionOnFail()
    {
        $this->fixture->addOrUpdateContactNote(201, array(
            'Id' => 666, 'NoteType' => 'This array is missing stuff'
        ));
    }

    /**
     * @covers ConnectWiseApi\Contact::findCompanies
     **/
    public function testFindCompaniesReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->findCompanies(5, 0, 'Id')));
    }

    /**
     * @covers ConnectWiseApi\Contact::findCompanies
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testFindCompaniesBadParamsThrowsException()
    {
        // Set these to whatever to test parameter value type fails
        $limit = 5;                 // expects integer
        $skip = 0;                    // expects integer
        $conditions = 'sdf = sdfsd';    // expects string
        $orderBy = 'Id';                   // expects string

        $this->fixture->findCompanies($limit, $skip, $orderBy, $conditions);
    }

    /**
     * @covers ConnectWiseApi\Contact::findContacts
     **/
    public function testFindContactsReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->findContacts(20, 0, 'Id')));
    }

    /**
     * @covers ConnectWiseApi\Contact::findContacts
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testFindContactsBadParamsThrowsException()
    {
        // Set these to whatever to test parameter value type fails
        $limit = 'fdf';                 // expects integer
        $skip = 0;                    // expects integer
        $conditions = 'sdf = sdfsd';    // expects string
        $orderBy = 'Id';                   // expects string

        $this->fixture->findContacts($limit, $skip, $orderBy, $conditions);
    }

    /**
     * @covers ConnectWiseApi\Contact::findContactsCount
     **/
    public function testFindContactsCountReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->findContactsCount('FirstName = "LTWebDevGuy"')));
    }

    /**
     * @covers ConnectWiseApi\Contact::findContactsCount
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testFindContactsCountThrowsExceptionOnFail()
    {
        $this->fixture->findContactsCount('NonExistentKey = "Bad Value 0912309"');
    }

    /**
     * @covers ConnectWiseApi\Contact::getAllCommunicationTypesAndDescriptions
     **/
    public function testGetAllCommunicationTypesAndDescriptionsCountReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->getAllCommunicationTypesAndDescriptions()));
    }

    /**
     * @covers ConnectWiseApi\Contact::getAllContactCommunicationItems
     **/
    public function testGetAllContactCommunicationItemsReturnsPopulatedArrayOnSuccess()
    {
        $this->assertGreaterThan(0, count($this->fixture->getAllContactCommunicationItems(2)));
    }

    /**
     * @covers ConnectWiseApi\Contact::getAllContactCommunicationItems
     **/
    public function testGetAllContactCommunicationItemsReturnsEmptyArrayForNonExistentContact()
    {
        $this->assertEquals(0, count($this->fixture->getAllContactCommunicationItems(9846846)));
    }

    /**
     * @covers ConnectWiseApi\Contact::getAllContactCommunicationItems
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetAllContactCommunicationItemsThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getAllContactCommunicationItems('supposed_to_be_an_integer');
    }

    /**
     * @covers ConnectWiseApi\Contact::getAllContactNotes
     **/
    public function testGetAllContactNotesReturnsPopulatedArrayOnSuccess()
    {
        $this->assertGreaterThan(0, count($this->fixture->getAllContactNotes(2)));
    }

    /**
     * @covers ConnectWiseApi\Contact::getAllContactNotes
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testGetAllContactNotesThrowsExceptionForNonExistentContact()
    {
        $this->fixture->getAllContactNotes(9846846);
    }

    /**
     * @covers ConnectWiseApi\Contact::getAllContactNotes
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetAllContactNotesThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getAllContactNotes('supposed_to_be_an_integer');
    }

    /**
     * @covers ConnectWiseApi\Contact::getAvatarImage
     *
     * @expectedException ConnectWiseApi\ApiException
     **/
    public function testGetAvatarImageThrowsExceptionWhenNoImageFound()
    {
        $this->fixture->getAvatarImage('k2h398fhsdfjhxcv');
    }

    /**
     * @covers ConnectWiseApi\Contact::getAvatarImage
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetAvatarImageThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getAvatarImage(649846);
    }

    /**
     * @covers ConnectWiseApi\Contact::getContact
     **/
    public function testGetContactReturnsPopulatedArrayOnSuccess()
    {
        $getContact = $this->fixture->getContact(2);

        $this->assertTrue(is_array($getContact));
        $this->assertGreaterThan(0, count($getContact));
    }

    /**
     * @covers ConnectWiseApi\Contact::getContact
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetContactThrowsExceptionWhenContactNotFound()
    {
        $this->fixture->getContact(98654);
    }

    /**
     * @covers ConnectWiseApi\Contact::getContact
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetContactThrowsExceptionOnOverflow()
    {
        $this->fixture->getContact(986541613646548);
    }

    /**
     * @covers ConnectWiseApi\Contact::getContact
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetContactThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getContact('supposed_to_be_an_integer');
    }

    /**
     * @covers ConnectWiseApi\Contact::getContactCommunicationItem
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetContactCommunicationItemThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getContactCommunicationItem('should_be_integer', 1123, array());
    }

    /**
     * @covers ConnectWiseApi\Contact::getContactCommunicationItem
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetContactCommunicationItemThrowsExceptionIfNotFound()
    {
        $this->fixture->getContactCommunicationItem(2, 'FaxNumber', 'DoesntExist');
    }

    /**
     * @covers ConnectWiseApi\Contact::getContactCommunicationItem
     **/
    public function testGetContactCommunicationItemReturnsPopulatedArrayOnSuccess()
    {
        $getContactCommItem = $this->fixture->getContactCommunicationItem(2, 'PhoneNumber', 'Direct');

        $this->assertTrue(is_array($getContactCommItem));
        $this->assertGreaterThan(0, count($getContactCommItem));
    }

    /**
     * @covers ConnectWiseApi\Contact::getContactNote
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetContactNoteThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getContactNote('should_be_integer', 'also_should_be_integer');
    }

    /**
     * @covers ConnectWiseApi\Contact::getContactNote
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetContactNoteThrowsExceptionIfNotFound()
    {
        $this->fixture->getContactNote(0, 0);
    }

    /**
     * @covers ConnectWiseApi\Contact::getContactNote
     **/
    public function testGetContactNoteReturnsPopulatedArrayOnSuccess()
    {
        $getContactNote = $this->fixture->getContactNote(2, 12);

        $this->assertTrue(is_array($getContactNote));
        $this->assertGreaterThan(0, count($getContactNote));
    }

    /**
     * @covers ConnectWiseApi\Contact::getPortalConfigSettings
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetPortalConfigSettingsThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getPortalConfigSettings(123);
    }

    /**
     * @covers ConnectWiseApi\Contact::getPortalConfigSettings
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetPortalConfigSettingsThrowsExceptionIfNotFound()
    {
        $this->fixture->getPortalConfigSettings('nonexistent_portal_name');
    }

    /**
     * @covers ConnectWiseApi\Contact::getPortalConfigSettings
     **/
    public function testGetPortalConfigSettingsReturnsPopulatedArrayOnSuccess()
    {
        $getPortalConfigSettings = $this->fixture->getPortalConfigSettings('Default');

        $this->assertTrue(is_array($getPortalConfigSettings));
        $this->assertGreaterThan(0, count($getPortalConfigSettings));
    }

    /**
     * @covers ConnectWiseApi\Contact::getPortalLoginCustomizations
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetPortalLoginCustomizationsThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getPortalLoginCustomizations(666);
    }

    /**
     * @covers ConnectWiseApi\Contact::getPortalLoginCustomizations
     */
    public function testGetPortalLoginCustomizationsReturnsEmptyArrayIfNotFound()
    {
        $getCustomizations = $this->fixture->getPortalLoginCustomizations('This_portal_does_not_exist');

        $this->assertTrue(is_array($getCustomizations));
        $this->assertEquals(0, count($getCustomizations));
    }

    /**
     * @covers ConnectWiseApi\Contact::getPortalLoginCustomizations
     **/
    public function testGetPortalLoginCustomizationsReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->getPortalLoginCustomizations('Default')));
    }

    /**
     * @covers ConnectWiseApi\Contact::getPortalSecurity
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testGetPortalSecurityThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getPortalSecurity('this_should_be_an_integer', 123);
    }

    /**
     * @covers ConnectWiseApi\Contact::getPortalSecurity
     */
    public function testGetPortalSecurityReturnsPopulatedArrayIfNotFound()
    {
        $this->assertTrue(is_array($this->fixture->getPortalSecurity(666, 'Invalid Co')));
    }

    /**
     * @covers ConnectWiseApi\Contact::getPortalSecurity
     **/
    public function testGetPortalSecurityReturnsPopulatedArrayOnSuccess()
    {
        $getPortalSecurity = $this->fixture->getPortalSecurity(1);

        $this->assertTrue(is_array($getPortalSecurity));
        $this->assertGreaterThan(0, count($getPortalSecurity));
    }

    /**
     * @covers ConnectWiseApi\Contact::loadContact
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testLoadContactThrowsExceptionOnNonIntegerParam()
    {
        $this->fixture->loadContact('this_should_be_an_integer');
    }

    /**
     * @covers ConnectWiseApi\Contact::loadContact
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testLoadContactThrowsExceptionIfContactNotFound()
    {
        $this->fixture->loadContact(666);
    }

    /**
     * @covers ConnectWiseApi\Contact::loadContact
     */
    public function testLoadContactReturnsPopulatedArrayOnSuccess()
    {
        $loadContact = $this->fixture->loadContact(2);

        $this->assertTrue(is_array($loadContact));
        $this->assertGreaterThan(1, count($loadContact));
    }

    /**
     * @covers ConnectWiseApi\Contact::removeContactFromGroup
     */
    /*
    public function testRemoveContactFromGroupReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->removeContactFromGroup(2, 20, 'testing')));
    }
    */

    /**
     * @covers ConnectWiseApi\Contact::removeContactFromGroup
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testRemoveContactFromGroupThrowsExceptionOnFail()
    {
        $this->fixture->removeContactFromGroup(2, 200, 'sdfsd');
    }

    /**
     * @covers ConnectWiseApi\Contact::requestPassword
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testRequestPasswordThrowsExceptionOnNonStringParam()
    {
        $this->fixture->requestPassword(123567);
    }

    /**
     * @covers ConnectWiseApi\Contact::requestPassword
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testRequestPasswordThrowsExceptionOnNonExistentEmail()
    {
        $this->fixture->requestPassword('jhfcx67123_this_email_address@does_not_exist_in_cw.io');
    }

    /**
     * @covers ConnectWiseApi\Contact::requestPassword
     */
    public function testRequestPasswordReturnsEmptyArrayOnSuccess()
    {
        $reqPass = $this->fixture->requestPassword('dontemailmebrozz@domain.com');

        $this->assertTrue(is_array($reqPass));
        $this->assertEquals(0, count($reqPass));
    }

    /**
     * @covers ConnectWiseApi\Contact::setDefaultContactCommunicationItem
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testSetDefaultContactCommunicationItemThrowsExceptionOnWrongParamValueTypes()
    {
        $this->fixture->setDefaultContactCommunicationItem('should_be_integer', 12, 12);
    }

    /**
     * @covers ConnectWiseApi\Contact::setDefaultContactCommunicationItem
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testSetDefaultContactCommunicationItemThrowsExceptionOnParamNonExist()
    {
        $this->fixture->setDefaultContactCommunicationItem(240, 'NonExistentType', 'UnknownParam');
    }

    /**
     * @covers ConnectWiseApi\Contact::setDefaultContactCommunicationItem
     */
    public function testSetDefaultContactCommunicationItemReturnsPopulatedArrayOnSuccess()
    {
        $setDefaultContactCommItem = $this->fixture->setDefaultContactCommunicationItem(2, 'PhoneNumber', 'Direct');

        $this->assertTrue(is_array($setDefaultContactCommItem));
        $this->assertGreaterThan(1, count($setDefaultContactCommItem));
    }

    /**
     * @covers ConnectWiseApi\Contact::deleteContact
     */
    public function testDeleteContactReturnsEmptyArrayOnSuccess()
    {
        $deleteContact = $this->fixture->deleteContact(245);

        $this->assertTrue(is_array($deleteContact));
        $this->assertEquals(0, count($deleteContact));
    }

    /**
     * @covers ConnectWiseApi\Contact::deleteContact
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testDeleteContactThrowsExceptionOnNonIntegerParam()
    {
        $this->fixture->deleteContact('should_be_integer');
    }

    /**
     * @covers ConnectWiseApi\Contact::deleteContact
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testDeleteContactThrowsExceptionOnContactNonExists()
    {
        $this->fixture->deleteContact(666);
    }

    /**
     * @covers ConnectWiseApi\Contact::deleteContactCommunicationItem
     */
    public function testDeleteContactCommunicationItemReturnsEmptyArrayOnSuccess()
    {
        $deleteCommItem = $this->fixture->deleteContactCommunicationItem(248, 'PhoneNumber', 'Cell');

        $this->assertTrue(is_array($deleteCommItem));
        $this->assertEquals(0, count($deleteCommItem));
    }

    /**
     * @covers ConnectWiseApi\Contact::deleteContactCommunicationItem
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testDeleteContactCommunicationItemThrowsExceptionOnInvalidParams()
    {
        $this->fixture->deleteContactCommunicationItem('should_be_integer', 123, 123);
    }

    /**
     * @covers ConnectWiseApi\Contact::deleteContactCommunicationItem
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testDeleteContactCommunicationItemThrowsExceptionOnParamNonExists()
    {
        $this->fixture->deleteContactCommunicationItem(666, 'CommItem', 'Fake');
    }

    /**
     * @covers ConnectWiseApi\Contact::deleteNote
     */
    public function testDeleteNoteReturnsEmptyArrayOnSuccess()
    {
        $deleteNote = $this->fixture->deleteNote(48, 248);

        $this->assertTrue(is_array($deleteNote));
        $this->assertEquals(0, count($deleteNote));
    }

    /**
     * @covers ConnectWiseApi\Contact::deleteNote
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testDeleteNoteThrowsExceptionOnInvalidParams()
    {
        $this->fixture->deleteNote('should_be_integer', 'should_be_integer');
    }

    /**
     * @covers ConnectWiseApi\Contact::deleteNote
     *
     * @expectedException ConnectWiseApi\ApiException
     */
    public function testDeleteNoteThrowsExceptionOnParamNonExists()
    {
        $this->fixture->deleteNote(666, 666);
    }
}