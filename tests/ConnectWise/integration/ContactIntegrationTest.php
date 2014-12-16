<?php namespace LabtechSoftware\ConnectwisePsaSdk;

class ContactIntegrationTest extends PsaTestCase
{
    protected $configuration;
    protected $factory;
    protected $fixture;

    protected function setUp()
    {
        $this->configuration = parent::setUp();
        $this->factory = new ConnectwiseApiFactory();
        $this->fixture = $this->factory->make(
            'Contact',
            $this->configuration
        );
    }

    public function testAddContact()
    {
        $data = [
            'ManagerID' => 0,
            'AssistantID' => 0,
            'ContactRecID' => 0,
            'Id' => 0,
            'Gender' => 'Male',
            'BirthDay' => '1985-01-07T00:00:00',
            'Married' => false,
            'Children' => false,
            'Anniversary' => '2005-01-07T00:00:00',
            'PortalSecurityLevel' => 1,
            'DisablePortalLogin' => true,
            'Inactive' => true,
            'UnsubscribeFlag' => true,
            'LastUpdate' => '2008-01-07T00:00:00',
            'PersonalAddressFlag' => true,
            'FirstName' => 'John',
            'LastName' => 'Doe'
        ];
        $results = $this->fixture->addOrUpdateContact($data);
        $this->assertInternalType('object', $results);
        $results = $results->AddOrUpdateContactResult;
        $this->assertContactStructure($results);

        return $results->Id;
    }

    /**
     * @depends testAddContact
     * @param $contactID
     */
    public function testAddContactCommunicationItem($contactID)
    {
        $data = [
            'Id' => 0,
            'Type' => 'EmailAddress',
            'CommunicationTypeId' => 0,
            'Description' => 'Email',
            'Value' => 'j.doe@example.com',
            'IsDefaultForType' => true
        ];
        $results = $this->fixture->addOrUpdateContactCommunicationItem($contactID, $data);
        $this->assertInternalType('object', $results);
        $results = $results->ContactMethod;
        $this->assertContactMethodStructure($results);

        return [
            'Email' => $data['Value'],
            'Type' => $data['Type'],
            'Description' => $data['Description']
        ];
    }

    /**
     * @depends testAddContact
     * @param $contactID
     */
    public function testAddContactNote($contactID)
    {
        $data = [
            'Id' => 0,
            'NoteType' => 'Comment',
            'NoteText' => 'Hello, World!',
            'IsFlagged' => 'False',
            'EnteredBy' => 'Test',
            'LastUpdatedBy' => 'Jason Jones',
            'LastUpdatedOn' => '2007-01-07T00:00:00-05:00'
        ];
        $results = $this->fixture->addOrUpdateContactNote($contactID, $data);
        $this->assertInternalType('object', $results);
        $results = $results->AddOrUpdateContactNoteResult;
        $this->assertContactNoteStructure($results);

        return $results->Id;
    }

    /**
     * @depends testAddContact
     * @param $contactID
     */
    public function testAddContactToGroup($contactID)
    {
        $groupID = 3124;
        $results = $this->fixture->addContactToGroup($contactID, $groupID);

        $this->assertInternalType('object', $results);
        $this->assertSame(true, $results->AddContactToGroupResult);

        return $groupID;
    }

//    public function testAuthenticate()
//    {
//
//    }

    public function testGetAllCommunicationTypesAndDescriptions()
    {
        $results = $this->fixture->getAllCommunicationTypesAndDescriptions();
        $this->assertInternalType('object', $results);
        $results = $results->GetAllCommunicationTypesAndDescriptionResult;
        $this->assertInternalType('object', $results);
        $results = $results->CommunicationTypeDescriptions;
        $this->assertInternalType('array', $results);
        foreach ($results as $result) {
            $this->assertCommunicationTypeDescriptionsStructure($result);
        }
    }

    /**
     * @depends testAddContact
     * @param $contactID
     */
    public function testGetAllContactCommunicationItems($contactID)
    {
        $results = $this->fixture->getAllContactCommunicationItems($contactID);
        $this->assertInternalType('object', $results);
        $results = $results->GetAllContactCommunicationItemsResult;
        $this->assertContactCommunicationItemStructure($results->ContactCommunicationItem);
    }

    /**
     * @depends testAddContact
     * @param $contactID
     */
    public function testGetAllContactNotes($contactID)
    {
        $results = $this->fixture->getAllContactNotes($contactID);
        $this->assertInternalType('object', $results);
        $results = $results->GetAllContactNotesResult;
        $this->assertContactNoteStructure($results->ContactNote);
    }

    /**
     * @depends testAddContact
     * @param $contactID
     */
    public function testGetContact($contactID)
    {
        $results = $this->fixture->getContact($contactID);
        $this->assertInternalType('object', $results);
        $results = $results->GetContactResult;
        $this->assertContactStructure($results);
    }

    /**
     * @depends testAddContact
     * @depends testAddContactCommunicationItem
     * @param $contactID
     * @param $itemInfo
     */
    public function testGetContactCommunicationItem($contactID, $itemInfo)
    {
        $results = $this->fixture->getContactCommunicationItem($contactID, $itemInfo['Type'], $itemInfo['Description']);
        $this->assertInternalType('object', $results);
        $results = $results->ContactMethod;
        $this->assertContactMethodStructure($results);
    }

    /**
     * @depends testAddContact
     * @depends testAddContactNote
     * @param $contactID
     * @param $noteID
     */
    public function testGetContactNote($contactID, $noteID)
    {
        $results = $this->fixture->getContactNote($contactID, $noteID);
        $this->assertInternalType('object', $results);
        $results = $results->GetContactNoteResult;
        $this->assertContactNoteStructure($results);
    }

    public function testGetPortalConfigSettings()
    {
        $results = $this->fixture->getPortalConfigSettings('Default');
        $this->assertInternalType('object', $results);
        $results = $results->GetPortalConfigSettingsResult;
        $this->assertPortalConfigSettingsStructure($results);
    }

    public function testGetPortalLoginCustomizations()
    {
        $results = $this->fixture->getPortalLoginCustomizations('Default');
        $this->assertInternalType('object', $results);
        $results = $results->GetPortalLoginCustomizationsResult;
        $this->assertPortalLoginCustomizationsStructure($results);
    }

    public function testGetPortalSecurity()
    {
        $results = $this->fixture->getPortalSecurity(0, '');
        $this->assertInternalType('object', $results);
        $results = $results->GetPortalSecurityResult;
        $this->assertPortalSecurityStructure($results);
    }

    /**
     * @todo Why does it fail with SecurityException Username or Password is incorrect?
     * This test fails, and we don't quite know why.
     *
     * @depends testAddContact
     * @depends testAddContactToGroup
     * @param $contactID
     * @param $groupID
     */
    public function testRemoveContactFromGroup($contactID, $groupID)
    {
        $this->markTestSkipped('This test fails, and we are not sure why.');
        $results = $this->fixture->removeContactFromGroup($contactID, $groupID);
    }

    /**
     * @depends testAddContactCommunicationItem
     * @param $itemInfo
     */
    public function testRequestPassword($itemInfo)
    {
        $results = $this->fixture->requestPassword($itemInfo['Email']);
        $this->assertInternalType('object', $results);
    }

    /**
     * @depends testAddContact
     * @depends testAddContactCommunicationItem
     * @param $contactID
     * @param $itemInfo
     */
    public function testSetDefaultContactCommunicationItem($contactID, $itemInfo)
    {
        $results = $this->fixture->setDefaultContactCommunicationItem(
            $contactID,
            $itemInfo['Type'],
            $itemInfo['Description']
        );
        $this->assertInternalType('object', $results);
        $results = $results->ContactMethod;
        $this->assertContactMethodStructure($results);
    }

    /**
     * @depends testAddContact
     * @param $contactID
     */
    public function testUpdateContact($contactID)
    {
        $data = [
            'ManagerID' => 0,
            'AssistantID' => 0,
            'ContactRecID' => 0,
            'Id' => $contactID,
            'Gender' => 'Female',
            'BirthDay' => '1985-01-07T00:00:00',
            'Married' => false,
            'Children' => false,
            'Anniversary' => '2005-01-07T00:00:00',
            'PortalSecurityLevel' => 1,
            'DisablePortalLogin' => true,
            'Inactive' => true,
            'UnsubscribeFlag' => true,
            'LastUpdate' => '2008-01-07T00:00:00',
            'PersonalAddressFlag' => true,
            'FirstName' => 'Jane',
            'LastName' => 'Doe'
        ];
        $results = $this->fixture->addOrUpdateContact($data);
    }

    /**
     * @depends testAddContact
     * @depends testAddContactCommunicationItem
     * @param $contactID
     * @param $itemInfo
     */
    public function testUpdateContactCommunicationItem($contactID, $itemInfo)
    {
        $data = [
            'Id' => 0,
            'Type' => $itemInfo['Type'],
            'CommunicationTypeId' => 0,
            'Description' => $itemInfo['Description'],
            'Value' => 'jane.doe@example.com',
            'IsDefaultForType' => true
        ];
        $results = $this->fixture->addOrUpdateContactCommunicationItem($contactID, $data);
    }

    /**
     * @depends testAddContact
     * @depends testAddContactNote
     * @param $contactID
     * @param $noteID
     */
    public function testUpdateContactNote($contactID, $noteID)
    {
        $data = [
            'Id' => $noteID,
            'NoteType' => 'Comment',
            'NoteText' => 'Hello, World!',
            'IsFlagged' => 'False',
            'EnteredBy' => 'Test',
            'LastUpdatedBy' => 'Jason Jones',
            'LastUpdatedOn' => '2007-01-07T00:00:00-05:00'
        ];
        $results = $this->fixture->addOrUpdateContactNote($contactID, $data);
    }

    /**
     * @depends testAddContact
     * @depends testAddContactNote
     * @param $contactID
     * @param $noteID
     */
    public function testDeleteContactNote($contactID, $noteID)
    {
        $results = $this->fixture->deleteNote($noteID, $contactID);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @depends testAddContact
     * @depends testAddContactCommunicationItem
     * @param $contactID
     * @param $itemID
     */
    public function testDeleteContactCommunicationItem($contactID, $itemInfo)
    {
        $results = $this->fixture->deleteContactCommunicationItem(
            $contactID,
            $itemInfo['Type'],
            $itemInfo['Description']
        );
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @depends testAddContact
     * @param $contactID
     */
    public function testDeleteContact($contactID)
    {
        $results = $this->fixture->deleteContact($contactID);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * Tests whether or not find contacts returns a contact object
     * when only one is returned and an array of contact objects
     * when more than one is returned, as we expect.
     *
     * @dataProvider singleVsMultipleCheckDataProvider
     * @param $count
     */
    public function testFindContacts($count)
    {
        $results = $this->fixture->findContacts($count, 0, '', '');
        $this->assertInternalType('object', $results);
        $results = $results->FindContactsResult;
        $this->assertInternalType('object', $results);
        $results = $results->ContactFindResult;
        if ($count === 1) {
            $this->assertFindContactStructure($results);
        } else {
            $this->assertInternalType('array', $results);
            foreach ($results as $result) {
                $this->assertFindContactStructure($result);
            }
        }
    }

    public function testFindContactsCount()
    {
        $results = $this->fixture->findContactsCount('');
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->FindContactsCountResult);
    }

    /**
     * @return array
     */
    public static function singleVsMultipleCheckDataProvider()
    {
        return [
            [1],
            [2],
            [5]
        ];
    }

    private function assertCommunicationTypeDescriptionsStructure($results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('array', $results->Description);
        foreach ($results->Description as $desc) {
            $this->assertInternalType('string', $desc);
        }
        $this->assertInternalType('string', $results->Type);
    }

    private function assertContactStructure($results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('string', $results->SID);
        $this->assertInternalType('integer', $results->ManagerID);
        $this->assertInternalType('integer', $results->AssistantID);
        $this->assertInternalType('string', $results->Relationship);
        $this->assertInternalType('integer', $results->ContactRecID);
        $this->assertInternalType('integer', $results->Id);
        $this->assertInternalType('string', $results->FirstName);
        $this->assertInternalType('string', $results->LastName);
        $this->assertInternalType('string', $results->Title);
        $this->assertInternalType('object', $results->PersonalAddress);
        $this->assertInternalType('object', $results->PersonalAddress->StreetLines);
        $this->assertInternalType('string', $results->PersonalAddress->City);
        $this->assertInternalType('string', $results->PersonalAddress->State);
        $this->assertInternalType('string', $results->PersonalAddress->Zip);
        $this->assertInternalType('string', $results->PersonalAddress->Country);
        $this->assertInternalType('string', $results->NickName);
        $this->assertInternalType('string', $results->Gender);
        $this->assertInternalType('string', $results->School);
        $this->assertNotFalse(strtotime($results->BirthDay));
        $this->assertInternalType('boolean', $results->Married);
        $this->assertInternalType('boolean', $results->Children);
        $this->assertInternalType('string', $results->SignificantOther);
        $this->assertNotFalse(strtotime($results->Anniversary));
        $this->assertInternalType('string', $results->PortalPassword);
        $this->assertInternalType('integer', $results->PortalSecurityLevel);
        $this->assertInternalType('boolean', $results->DisablePortalLogin);
        $this->assertInternalType('boolean', $results->Inactive);
        $this->assertInternalType('boolean', $results->UnsubscribeFlag);
        $this->assertNotFalse(strtotime($results->LastUpdate));
        $this->assertInternalType('string', $results->UpdatedBy);
        $this->assertInternalType('object', $results->PersonalAddress);
        $this->assertInternalType('object', $results->Phones);
        $this->assertInternalType('array', $results->Phones->ContactCommunicationItem);
        foreach ($results->Phones->ContactCommunicationItem as $contactCommunicationItem) {
            $this->assertContactCommunicationItemStructure($contactCommunicationItem, true);
        }
        $this->assertInternalType('object', $results->Emails);
        $this->assertInternalType('array', $results->Emails->ContactCommunicationItem);
        foreach ($results->Emails->ContactCommunicationItem as $contactCommunicationItem) {
            $this->assertContactCommunicationItemStructure($contactCommunicationItem, true);
        }
        $this->assertInternalType('object', $results->Faxes);
        $this->assertInternalType('array', $results->Faxes->ContactCommunicationItem);
        foreach ($results->Faxes->ContactCommunicationItem as $contactCommunicationItem) {
            $this->assertContactCommunicationItemStructure($contactCommunicationItem, true);
        }
    }

    private function assertContactCommunicationItemStructure($results, $valueExtension = false)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->Id);
        $this->assertInternalType('string', $results->Type);
        $this->assertInternalType('integer', $results->CommunicationTypeId);
        $this->assertInternalType('string', $results->Description);
        $this->assertInternalType('string', $results->Value);
        $this->assertInternalType('boolean', $results->IsDefaultForType);
        if ($valueExtension === true) {
            $this->assertInternalType('string', $results->ValueExtension);
        }
    }

    private function assertContactNoteStructure($results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->Id);
        $this->assertInternalType('string', $results->NoteType);
        $this->assertInternalType('string', $results->NoteText);
        $this->assertInternalType('boolean', $results->IsFlagged);
        $this->assertInternalType('string', $results->EnteredBy);
        $this->assertInternalType('string', $results->LastUpdatedBy);
        $this->assertNotFalse(strtotime($results->LastUpdatedOn));
    }

    private function assertContactMethodStructure($results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->Id);
        $this->assertInternalType('string', $results->Type);
        $this->assertInternalType('integer', $results->CommunicationTypeId);
        $this->assertInternalType('string', $results->Description);
        $this->assertInternalType('string', $results->Value);
        $this->assertInternalType('boolean', $results->IsDefaultForType);
    }

    private function assertFindContactStructure($results)
    {
        $this->assertInternalType('string', $results->FirstName);
        $this->assertInternalType('string', $results->LastName);
        $this->assertInternalType('string', $results->CompanyName);
        $this->assertInternalType('integer', $results->CompanyRecID);
        $this->assertInternalType('string', $results->Phone);
        $this->assertInternalType('string', $results->Email);
        $this->assertInternalType('string', $results->Type);
        $this->assertInternalType('string', $results->Relationship);
        $this->assertInternalType('boolean', $results->DefaultFlag);
        $this->assertInternalType('string', $results->AddressLine1);
        $this->assertInternalType('string', $results->AddressLine2);
        $this->assertInternalType('string', $results->City);
        $this->assertInternalType('string', $results->State);
        $this->assertInternalType('string', $results->Zip);
        $this->assertInternalType('string', $results->Country);
        $this->assertInternalType('integer', $results->PortalSecurityLevel);
        $this->assertInternalType('string', $results->PortalSecurityCaption);
        $this->assertInternalType('boolean', $results->DisablePortalLogin);
        $this->assertNotFalse(strtotime($results->LastUpdate));
        $this->assertInternalType('integer', $results->ContactRecID);
        $this->assertInternalType('integer', $results->Id);
    }

    private function assertIconStructure($results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('string', $results->Id);
        $this->assertInternalType('string', $results->Url);
        $this->assertInternalType('boolean', $results->UrlFlag);
        $this->assertInternalType('integer', $results->PortalImageId);
    }

    private function assertPortalConfigSettingsStructure($results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('string', $results->PortalName);
        $this->assertInternalType('boolean', $results->SrTypeFlag);
        $this->assertInternalType('boolean', $results->SrSubTypeFlag);
        $this->assertInternalType('boolean', $results->SrSubTypeItemFlag);
        $this->assertInternalType('boolean', $results->SrContactFlag);
        $this->assertInternalType('boolean', $results->SrEnteredFlag);
        $this->assertInternalType('boolean', $results->SrStatusFlag);
        $this->assertInternalType('boolean', $results->SrSiteFlag);
        $this->assertInternalType('boolean', $results->SrUpdateFlag);
        $this->assertInternalType('boolean', $results->SrResourcesFlag);
        $this->assertInternalType('boolean', $results->SrRequiredFlag);
        $this->assertInternalType('boolean', $results->ShowSlaInfoFlag);
        $this->assertInternalType('boolean', $results->SrBoardFlag);
        $this->assertInternalType('boolean', $results->SrBudgetFlag);
        $this->assertInternalType('boolean', $results->SrActualFlag);
        $this->assertInternalType('boolean', $results->SrApprovedFlag);
        $this->assertInternalType('boolean', $results->SrOpenTasksFlag);
        $this->assertInternalType('boolean', $results->SrClosedTasksFlag);
        $this->assertInternalType('boolean', $results->PmNameFlag);
        $this->assertInternalType('boolean', $results->PmTypeFlag);
        $this->assertInternalType('boolean', $results->PmStatusFlag);
        $this->assertInternalType('boolean', $results->PmManagerFlag);
        $this->assertInternalType('boolean', $results->PmBillingMethodFlag);
        $this->assertInternalType('boolean', $results->PmContactFlag);
        $this->assertInternalType('boolean', $results->PmEstimatedStartFlag);
        $this->assertInternalType('boolean', $results->PmEstimatedEndFlag);
        $this->assertInternalType('boolean', $results->PmDescriptionFlag);
        $this->assertInternalType('boolean', $results->PmLastUpdatedFlag);
        $this->assertInternalType('boolean', $results->ShowInvPmtFlag);
        $this->assertInternalType('boolean', $results->AllowInvPmtFlag);
        $this->assertNull($results->StatementReportOwnerLevelRecId);
        $this->assertInternalType('boolean', $results->StatementReportOwnerLevelRecIdSetByUser);
        $this->assertInternalType('boolean', $results->TmBudgetHrsFlag);
        $this->assertInternalType('boolean', $results->TmScheduledStartFlag);
        $this->assertInternalType('boolean', $results->TmScheduledFinishFlag);
        $this->assertInternalType('boolean', $results->TmScheduledHrsFlag);
        $this->assertInternalType('boolean', $results->TmActualStartFlag);
        $this->assertInternalType('boolean', $results->TmActualFinishFlag);
        $this->assertInternalType('boolean', $results->TmActualHrsFlag);
        $this->assertInternalType('boolean', $results->TmBillFlag);
        $this->assertInternalType('boolean', $results->TmStatusFlag);
        $this->assertInternalType('boolean', $results->TmAssignedFlag);
        $this->assertInternalType('boolean', $results->FfBudgetHrsFlag);
        $this->assertInternalType('boolean', $results->FfScheduledStartFlag);
        $this->assertInternalType('boolean', $results->FfScheduledFinishFlag);
        $this->assertInternalType('boolean', $results->FfScheduledHrsFlag);
        $this->assertInternalType('boolean', $results->FfActualStartFlag);
        $this->assertInternalType('boolean', $results->FfActualFinishFlag);
        $this->assertInternalType('boolean', $results->FfActualHrsFlag);
        $this->assertInternalType('boolean', $results->FfBillFlag);
        $this->assertInternalType('boolean', $results->FfStatusFlag);
        $this->assertInternalType('boolean', $results->FfAssignedFlag);
        $this->assertInternalType('boolean', $results->PiBudgetHrsFlag);
        $this->assertInternalType('boolean', $results->PiScheduledStartFlag);
        $this->assertInternalType('boolean', $results->PiScheduledFinishFlag);
        $this->assertInternalType('boolean', $results->PiScheduledHrsFlag);
        $this->assertInternalType('boolean', $results->PiActualStartFlag);
        $this->assertInternalType('boolean', $results->PiActualFinishFlag);
        $this->assertInternalType('boolean', $results->PiActualHrsFlag);
        $this->assertInternalType('boolean', $results->PiBillFlag);
        $this->assertInternalType('boolean', $results->PiStatusFlag);
        $this->assertInternalType('boolean', $results->PiAssignedFlag);
        $this->assertInternalType('object', $results->PortalImage);
        $this->assertIconStructure($results->PortalImage->IconServiceEntry);
        $this->assertIconStructure($results->PortalImage->IconCompanyEntries);
        $this->assertIconStructure($results->PortalImage->IconSelfHelp);
        $this->assertIconStructure($results->PortalImage->IconKnowledgebase);
        $this->assertIconStructure($results->PortalImage->IconMembers);
        $this->assertIconStructure($results->PortalImage->IconInvoiceSearch);
        $this->assertIconStructure($results->PortalImage->IconReports);
        $this->assertIconStructure($results->PortalImage->LoginLogo);
        $this->assertIconStructure($results->PortalImage->PortalLogo);
        $this->assertIconStructure($results->PortalImage->LoginMasthead);
        $this->assertIconStructure($results->PortalImage->ReportLogo);
        $this->assertInternalType('object', $results->MouseOverData);
        $this->assertInternalType('boolean', $results->MouseOverData->IsTicketStatusLoaded);
        $this->assertInternalType('integer', $results->Id);
        $this->assertInternalType('boolean', $results->DefaultFlag);
    }

    private function assertPortalLoginCustomizationsStructure($results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('string', $results->LoginColor);
    }

    private function assertPortalSecurityStructure($results)
    {
        $this->assertInternalType('object', $results);
        $this->assertInternalType('array', $results->PortalSecurity);
        foreach ($results->PortalSecurity as $item) {
            $this->assertInternalType('string', $item->SecurityId);
            $this->assertInternalType('boolean', $item->SecurityEnabled);
        }
    }
}
