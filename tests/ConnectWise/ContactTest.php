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
            'Id' => 0, 'NoteType' => 'Comment', 'NoteText' => 'iRack is for shoes', 'IsFlagged' => false
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
        $this->assertGreaterThan(1, count($this->fixture->getAllContactCommunicationItems(2)));
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
}