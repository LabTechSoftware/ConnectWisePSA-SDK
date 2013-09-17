<?php

/**
 * Tests for \ConnectwisePsaSdk\Contact
 * @todo Add tests for addContactToGroup, getAvatarImage, removeContactFromGroup
 *
 * @covers ConnectwisePsaSdk\Contact
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
        $this->fixture = new ConnectwisePsaSdk\Contact;

        // Set a random string to use in tests
        $this->randomString = 'Test Entry num' . rand(10, 1000);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact
     */
    public function testCurrentApiNameExists()
    {
        $this->assertObjectHasAttribute('currentApi', $this->fixture);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::addOrUpdateContact
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
     * @covers ConnectwisePsaSdk\Contact::addOrUpdateContact
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateContactThrowsExceptionWhenMissingRequiredInput()
    {
        $this->fixture->addOrUpdateContact(array(
            'FirstName' => 'LTWebDevGuy', 'LastName' => 'Testerino',
        ));
    }
    
    /**
     * @covers ConnectwisePsaSdk\Contact::addOrUpdateContactCommunicationItem
     */
    public function testAddOrUpdateContactCommunicationItemReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->addOrUpdateContactCommunicationItem(2, array(
            'Id' => 0, 'Type' => 'PhoneNumber', 'CommunicationTypeId' => 0, 'Description' => 'Direct'
        ))));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::addOrUpdateContactCommunicationItem
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateContactCommunicationItemThrowsExceptionOnFail()
    {
        $this->fixture->addOrUpdateContactCommunicationItem(0, array(
            'Description' => 'Testing...'
        ));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::addOrUpdateContactNote
     */
    public function testAddOrUpdateContactNoteReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->addOrUpdateContactNote(2, array(
            'Id' => 0, 'NoteType' => 'Comment', 'NoteText' => 'Lorem ipsum', 'IsFlagged' => false
        ))));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::addOrUpdateContactNote
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateContactNoteThrowsExceptionOnFail()
    {
        $this->fixture->addOrUpdateContactNote(201, array(
            'Id' => 666, 'NoteType' => 'This array is missing stuff'
        ));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::findCompanies
     **/
    public function testFindCompaniesReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->findCompanies(5, 0, 'Id')));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::findCompanies
     *
     * @expectedException ConnectwisePsaSdk\ApiException
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
     * @covers ConnectwisePsaSdk\Contact::findContacts
     **/
    public function testFindContactsReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->findContacts(20, 0, 'Id')));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::findContacts
     *
     * @expectedException ConnectwisePsaSdk\ApiException
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
     * @covers ConnectwisePsaSdk\Contact::findContactsCount
     **/
    public function testFindContactsCountReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->findContactsCount('FirstName = "LTWebDevGuy"')));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::findContactsCount
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testFindContactsCountThrowsExceptionOnFail()
    {
        $this->fixture->findContactsCount('NonExistentKey = "Bad Value 0912309"');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getAllCommunicationTypesAndDescriptions
     **/
    public function testGetAllCommunicationTypesAndDescriptionsCountReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->getAllCommunicationTypesAndDescriptions()));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getAllContactCommunicationItems
     **/
    public function testGetAllContactCommunicationItemsReturnsPopulatedArrayOnSuccess()
    {
        $this->assertGreaterThan(0, count($this->fixture->getAllContactCommunicationItems(2)));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getAllContactCommunicationItems
     **/
    public function testGetAllContactCommunicationItemsReturnsEmptyArrayForNonExistentContact()
    {
        $this->assertEquals(0, count($this->fixture->getAllContactCommunicationItems(9846846)));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getAllContactCommunicationItems
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetAllContactCommunicationItemsThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getAllContactCommunicationItems('supposed_to_be_an_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getAllContactNotes
     **/
    public function testGetAllContactNotesReturnsPopulatedArrayOnSuccess()
    {
        $this->assertGreaterThan(0, count($this->fixture->getAllContactNotes(2)));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getAllContactNotes
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     **/
    public function testGetAllContactNotesThrowsExceptionForNonExistentContact()
    {
        $this->fixture->getAllContactNotes(9846846);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getAllContactNotes
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetAllContactNotesThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getAllContactNotes('supposed_to_be_an_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContact
     **/
    public function testGetContactReturnsPopulatedArrayOnSuccess()
    {
        $getContact = $this->fixture->getContact(2);

        $this->assertTrue(is_array($getContact));
        $this->assertGreaterThan(0, count($getContact));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContact
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetContactThrowsExceptionWhenContactNotFound()
    {
        $this->fixture->getContact(98654);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContact
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetContactThrowsExceptionOnOverflow()
    {
        $this->fixture->getContact(986541613646548);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContact
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetContactThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getContact('supposed_to_be_an_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContactCommunicationItem
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetContactCommunicationItemThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getContactCommunicationItem('should_be_integer', 1123, array());
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContactCommunicationItem
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetContactCommunicationItemThrowsExceptionIfNotFound()
    {
        $this->fixture->getContactCommunicationItem(2, 'FaxNumber', 'DoesntExist');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContactCommunicationItem
     **/
    public function testGetContactCommunicationItemReturnsPopulatedArrayOnSuccess()
    {
        $getContactCommItem = $this->fixture->getContactCommunicationItem(2, 'PhoneNumber', 'Direct');

        $this->assertTrue(is_array($getContactCommItem));
        $this->assertGreaterThan(0, count($getContactCommItem));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContactNote
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetContactNoteThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getContactNote('should_be_integer', 'also_should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContactNote
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetContactNoteThrowsExceptionIfNotFound()
    {
        $this->fixture->getContactNote(0, 0);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getContactNote
     **/
    public function testGetContactNoteReturnsPopulatedArrayOnSuccess()
    {
        $getContactNote = $this->fixture->getContactNote(2, 12);

        $this->assertTrue(is_array($getContactNote));
        $this->assertGreaterThan(0, count($getContactNote));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getPortalConfigSettings
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetPortalConfigSettingsThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getPortalConfigSettings(123);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getPortalConfigSettings
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetPortalConfigSettingsThrowsExceptionIfNotFound()
    {
        $this->fixture->getPortalConfigSettings('nonexistent_portal_name');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getPortalConfigSettings
     **/
    public function testGetPortalConfigSettingsReturnsPopulatedArrayOnSuccess()
    {
        $getPortalConfigSettings = $this->fixture->getPortalConfigSettings('Default');

        $this->assertTrue(is_array($getPortalConfigSettings));
        $this->assertGreaterThan(0, count($getPortalConfigSettings));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getPortalLoginCustomizations
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetPortalLoginCustomizationsThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getPortalLoginCustomizations(666);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getPortalLoginCustomizations
     */
    public function testGetPortalLoginCustomizationsReturnsEmptyArrayIfNotFound()
    {
        $getCustomizations = $this->fixture->getPortalLoginCustomizations('This_portal_does_not_exist');

        $this->assertTrue(is_array($getCustomizations));
        $this->assertEquals(0, count($getCustomizations));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getPortalLoginCustomizations
     **/
    public function testGetPortalLoginCustomizationsReturnsArrayOnSuccess()
    {
        $this->assertTrue(is_array($this->fixture->getPortalLoginCustomizations('Default')));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getPortalSecurity
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetPortalSecurityThrowsExceptionOnInvalidParam()
    {
        $this->fixture->getPortalSecurity('this_should_be_an_integer', 123);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getPortalSecurity
     */
    public function testGetPortalSecurityReturnsPopulatedArrayIfNotFound()
    {
        $this->assertTrue(is_array($this->fixture->getPortalSecurity(666, 'Invalid Co')));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::getPortalSecurity
     **/
    public function testGetPortalSecurityReturnsPopulatedArrayOnSuccess()
    {
        $getPortalSecurity = $this->fixture->getPortalSecurity(1);

        $this->assertTrue(is_array($getPortalSecurity));
        $this->assertGreaterThan(0, count($getPortalSecurity));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::loadContact
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testLoadContactThrowsExceptionOnNonIntegerParam()
    {
        $this->fixture->loadContact('this_should_be_an_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::loadContact
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testLoadContactThrowsExceptionIfContactNotFound()
    {
        $this->fixture->loadContact(666);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::loadContact
     */
    public function testLoadContactReturnsPopulatedArrayOnSuccess()
    {
        $loadContact = $this->fixture->loadContact(2);

        $this->assertTrue(is_array($loadContact));
        $this->assertGreaterThan(1, count($loadContact));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::requestPassword
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testRequestPasswordThrowsExceptionOnNonStringParam()
    {
        $this->fixture->requestPassword(123567);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::requestPassword
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testRequestPasswordThrowsExceptionOnNonExistentEmail()
    {
        $this->fixture->requestPassword('jhfcx67123_this_email_address@does_not_exist_in_cw.io');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::requestPassword
     */
    public function testRequestPasswordReturnsEmptyArrayOnSuccess()
    {
        $reqPass = $this->fixture->requestPassword('dontemailmebrozz@domain.com');

        $this->assertTrue(is_array($reqPass));
        $this->assertEquals(0, count($reqPass));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::setDefaultContactCommunicationItem
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testSetDefaultContactCommunicationItemThrowsExceptionOnWrongParamValueTypes()
    {
        $this->fixture->setDefaultContactCommunicationItem('should_be_integer', 12, 12);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::setDefaultContactCommunicationItem
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testSetDefaultContactCommunicationItemThrowsExceptionOnParamNonExist()
    {
        $this->fixture->setDefaultContactCommunicationItem(240, 'NonExistentType', 'UnknownParam');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::setDefaultContactCommunicationItem
     */
    public function testSetDefaultContactCommunicationItemReturnsPopulatedArrayOnSuccess()
    {
        $setDefaultContactCommItem = $this->fixture->setDefaultContactCommunicationItem(2, 'PhoneNumber', 'Direct');

        $this->assertTrue(is_array($setDefaultContactCommItem));
        $this->assertGreaterThan(1, count($setDefaultContactCommItem));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::deleteContact
     */
    public function testDeleteContactReturnsEmptyArrayOnSuccess()
    {
        $deleteContact = $this->fixture->deleteContact(245);

        $this->assertTrue(is_array($deleteContact));
        $this->assertEquals(0, count($deleteContact));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::deleteContact
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteContactThrowsExceptionOnNonIntegerParam()
    {
        $this->fixture->deleteContact('should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::deleteContact
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteContactThrowsExceptionOnContactNonExists()
    {
        $this->fixture->deleteContact(666);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::deleteContactCommunicationItem
     */
    public function testDeleteContactCommunicationItemReturnsEmptyArrayOnSuccess()
    {
        $deleteCommItem = $this->fixture->deleteContactCommunicationItem(248, 'PhoneNumber', 'Cell');

        $this->assertTrue(is_array($deleteCommItem));
        $this->assertEquals(0, count($deleteCommItem));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::deleteContactCommunicationItem
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteContactCommunicationItemThrowsExceptionOnInvalidParams()
    {
        $this->fixture->deleteContactCommunicationItem('should_be_integer', 123, 123);
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::deleteContactCommunicationItem
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteContactCommunicationItemThrowsExceptionOnParamNonExists()
    {
        $this->fixture->deleteContactCommunicationItem(666, 'CommItem', 'Fake');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::deleteNote
     */
    public function testDeleteNoteReturnsEmptyArrayOnSuccess()
    {
        $deleteNote = $this->fixture->deleteNote(48, 248);

        $this->assertTrue(is_array($deleteNote));
        $this->assertEquals(0, count($deleteNote));
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::deleteNote
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteNoteThrowsExceptionOnInvalidParams()
    {
        $this->fixture->deleteNote('should_be_integer', 'should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\Contact::deleteNote
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteNoteThrowsExceptionOnParamNonExists()
    {
        $this->fixture->deleteNote(666, 666);
    }
}