<?php

/**
 * Tests for \ConnectwisePsaSdk\ServiceTicket
 * @todo Add tests for addOrUpdateServiceTicketViaManagedId, addServiceTicketViaManagedId, updateServiceTicketViaManagedId 
 *
 * @covers ConnectwisePsaSdk\ServiceTicket
 */
class ServiceTicketTest extends \PHPUnit_Framework_TestCase
{
    protected $fixture;

    protected $validTicketDataArray = array(
        'TicketNumber' =>  99, 'SendingSrServiceRecid' => 99, 'DateReq' => '2013-02-02', 'SubBillingMethodId' => 'None',
        'SubBillingAmount' => '100.00', 'SubDateAccepted' => '2013-01-02', 'SubDateAcceptedUtc' => '2013-01-01', 
        'BudgetHours' => '3.0', 'SkipCallback' => false, 'Approved' => false, 'ClosedFlag' => false, 'Summary' => 'This is a test (updated).',
        'Status' => 'N'
    );

    protected $validTicketProductArray = array(
        'Dropship' => false, 'SpecialOrder' => false, 'ForecastDetailId' => 0, 'TicketId' => 99, 'ProjectId' => 0, 
        'InvoiceId' => 0, 'SalesOrderId' => 0, 'Price' => 5.0, 'Cost' => 0.0, 'Quantity' => 3.00, 'ItemId' => 743, 
        'Description' => 'Test product', 'Invoice' => false, 'Taxable' => false, 'Billable' => false, 'Id' => 0,
        'OpportunityId' => 0, 'OwnerLevelRecid' => 2, 'Warehouse' => false, 'Bin' => false, 'BillingUnitRecid' => 10
    );

    /**
     * New instance for fixture
     */
    protected function setUp()
    {
        // Set class instance
        $this->fixture = new ConnectwisePsaSdk\ServiceTicket;
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket
     */
    public function testCurrentApiNameExists()
    {
        $this->assertObjectHasAttribute('currentApi', $this->fixture);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addOrUpdateServiceTicketViaCompanyId
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateServiceTicketViaCompanyIdThrowsExceptionOnNonStringCompanyId()
    {
        $this->fixture->addOrUpdateServiceTicketViaCompanyId(1231, array());
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addOrUpdateServiceTicketViaCompanyId
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateServiceTicketViaCompanyIdThrowsExceptionOnEmptyParams()
    {
        $this->fixture->addOrUpdateServiceTicketViaCompanyId('', array());
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addOrUpdateServiceTicketViaCompanyId
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateServiceTicketViaCompanyIdThrowsExceptionOnMissingTicketNumber()
    {
        $tempTicket = $this->validTicketDataArray;

        unset($tempTicket['TicketNumber']);
        
        $this->fixture->addOrUpdateServiceTicketViaCompanyId('ConnectWise', $tempTicket);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addOrUpdateServiceTicketViaCompanyId
     */
    public function testAddOrUpdateServiceTicketViaCompanyIdReturnsPopulatedArrayOnValidCompanyAndTicket()
    {
        $result = $this->fixture->addOrUpdateServiceTicketViaCompanyId('ConnectWise', $this->validTicketDataArray);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addOrUpdateTicketProduct
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateTicketProductThrowsExceptionOnMissingProductArrayItem()
    {
        $tempTicket = $this->validTicketProductArray;

        unset($tempTicket['TicketId']);

        $this->fixture->addOrUpdateTicketProduct($tempTicket);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addOrUpdateTicketProduct
     */
    public function testAddOrUpdateTicketProductReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->addOrUpdateTicketProduct($this->validTicketProductArray);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addServiceTicketViaCompanyId
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddServiceTicketViaCompanyIdThrowsExceptionOnBadCompanyIdParam()
    {
        $this->fixture->addServiceTicketViaCompanyId(123123, $this->validTicketDataArray);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addServiceTicketViaCompanyId
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddServiceTicketViaCompanyIdThrowsExceptionOnIncompleteTicketArray()
    {
        $tempTicket = $this->validTicketDataArray;

        unset($tempTicket['TicketNumber']);
        unset($tempTicket['Status']);

        $this->fixture->AddServiceTicketViaCompanyId('ConnectWise', $tempTicket);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addServiceTicketViaCompanyId
     */
    public function testAddServiceTicketViaCompanyIdReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->addServiceTicketViaCompanyId('ConnectWise', $this->validTicketDataArray);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addTicketProduct
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddTicketProductThrowsExceptionOnIncompleteProductArray()
    {
        $productArray = $this->validTicketProductArray;
        unset($productArray['TicketId']);

        $this->fixture->addTicketProduct($productArray);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addTicketProduct
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testAddTicketProductThrowsExceptionOnInvalidTicketId()
    {
        $productArray = $this->validTicketProductArray;
        $productArray['TicketId'] = 'this_is_an_invalid_ticket_id_24hoiegf9ajsacx';

        $this->fixture->addTicketProduct($productArray);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::addTicketProduct
     */
    public function testAddTicketProductReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->addTicketProduct($this->validTicketProductArray);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::findServiceTickets
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testFindServiceTicketsThrowsExceptionOnUnrecognizedCondition()
    {
        $this->fixture->findServiceTickets(5, 0, 'unknownColumndoesnotexist = 09j3lfksdjf093j');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::findServiceTickets
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testFindServiceTicketsThrowsExceptionOnUnknownSortByParam()
    {
        $this->fixture->findServiceTickets(5, 0, '', 'cant_sort_by_this');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::findServiceTickets
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testFindServiceTicketsThrowsExceptionOnWrongParamValueType()
    {
        $this->fixture->findServiceTickets('should_be_integer', 'should_be_integer', 123, 123);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::findServiceTickets
     */
    public function testFindServiceTicketsReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->findServiceTickets(5, 0);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::findServiceTickets
     */
    public function testFindServiceTicketsReturnsEmptyArrayWhenNoMatchesFound()
    {
        $result = $this->fixture->findServiceTickets(10, 0, 'Approved = false');

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getServiceStatuses
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetServiceStatusesThrowsExceptionOnNonIntegerParam()
    {
        $this->fixture->getServiceStatuses('should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getServiceStatuses
     */
    public function testGetServiceStatusesReturnsEmptyArrayForNonExistentTicket()
    {
        $result = $this->fixture->getServiceStatuses(99999);

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getServiceStatuses
     */
    public function testGetServiceStatusesReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->getServiceStatuses(960);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getServiceTicket
     */
    public function testGetServiceTicketReturnsEmptyArrayWhenTicketNotFound()
    {
        $result = $this->fixture->getServiceTicket(99999);

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getServiceTicket
     */
    public function testGetServiceTicketReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->getServiceTicket(960);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getServiceTicket
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetServiceTicketThrowsExceptionWhenParamIsNotInteger()
    {
        $this->fixture->getServiceTicket('should_be_an_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketCount
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetTicketCountThrowsExceptionOnInvalidConditions()
    {
        $this->fixture->getTicketCount(true, 'nonexists = "sldkfj2039"');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketCount
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetTicketCountThrowsExceptionOnNonBooleanFirstParam()
    {
        $this->fixture->getTicketCount('should_be_boolean');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketCount
     */
    public function testGetTicketCountReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->getTicketCount();

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::loadServiceTicket
     * 
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testLoadServiceTicketThrowsExceptionWhenTicketNotFound()
    {
        $this->fixture->loadServiceTicket(9999);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::loadServiceTicket
     * 
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testLoadServiceTicketThrowsExceptionOnNonIntegerParam()
    {
        $this->fixture->loadServiceTicket('should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::loadServiceTicket
     */
    public function testLoadServiceTicketReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->loadServiceTicket(960);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketProductList
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetTicketProductListThrowsExceptionOnNonIntegerParam()
    {
        $this->fixture->getTicketProductList('should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketProductList
     */
    public function testGetTicketProductListReturnsEmptyArrayWhenTicketNotFound()
    {
        $result = $this->fixture->getTicketProductList(99999);

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketProductList
     */
    public function testGetTicketProductListReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->getTicketProductList(960);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseThrowsExceptionOnBadParamValueType()
    {
        $this->fixture->searchKnowledgebase(123, 123, 123, 'should_be_integer', 'should_be_integer', 'should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseThrowsExceptionOnInvalidType()
    {
        $this->fixture->searchKnowledgebase('invoice', 'NonExistentType', '2000-01-01');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     */
    public function testSearchKnowledgebaseReturnsEmptyArrayWhenNoMatchesFound()
    {
        $result = $this->fixture->searchKnowledgebase('lsdkjf09jsdf', 'All', '2000-01-01');

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     */
    public function testSearchKnowledgebaseReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->searchKnowledgebase('invoice', 'All', '2000-01-01');

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::searchKnowledgebaseCount
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseCountThrowsExceptionOnInvalidType()
    {
        $this->fixture->searchKnowledgebaseCount('invoice', 'NonExistentType', '2000-01-01');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::searchKnowledgebaseCount
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseCountThrowsExceptionOnBadParamValueType()
    {
        $this->fixture->searchKnowledgebaseCount(123, 123, 123);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::searchKnowledgebaseCount
     */
    public function testSearchKnowledgebaseCountReturnsEmptyArrayWhenNoMatchesFound()
    {
        $result = $this->fixture->searchKnowledgebaseCount('lskfjlskjs123z', 'All', '2000-01-01');

        $this->assertTrue(is_array($result));
        $this->assertTrue(array_key_exists(0, $result));
        $this->assertEquals(0, $result[0]);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::searchKnowledgebaseCount
     */
    public function testSearchKnowledgebaseCountReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->searchKnowledgebaseCount('invoice', 'All', '2000-01-01');

        $this->assertTrue(is_array($result));
        $this->assertTrue(array_key_exists(0, $result));
        $this->assertGreaterThan(0, $result[0]);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketDocuments
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetTicketDocumentsThrowsExceptionWhenTicketNotFound()
    {
        $this->fixture->getTicketDocuments(23423);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketDocuments
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testGetTicketDocumentsThrowsExceptionNonIntegerParam()
    {
        $this->fixture->getTicketDocuments('should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketDocuments
     */
    /*
    public function testGetTicketDocumentsReturnsPopulatedArrayWhenDocumentsAvailableOnTicket()
    {
        $result = $this->fixture->getTicketDocuments(387);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }
    */

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::getTicketDocuments
     */
    public function testGetTicketDocumentsReturnsEmptyArrayNoDocumentsAvailableOnTicket()
    {
        $result = $this->fixture->getTicketDocuments(960);

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }

   /**
     * @covers ConnectwisePsaSdk\ServiceTicket::updateServiceTicketViaCompanyId
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testUpdateServiceTicketViaCompanyIdThrowsExceptionOnBadCompanyIdParam()
    {
        $this->fixture->updateServiceTicketViaCompanyId(123123, $this->validTicketDataArray);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::updateServiceTicketViaCompanyId
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testUpdateServiceTicketViaCompanyIdThrowsExceptionOnIncompleteTicketArray()
    {
        $tempTicket = $this->validTicketDataArray;

        unset($tempTicket['TicketNumber']);

        $this->fixture->updateServiceTicketViaCompanyId('ConnectWise', $tempTicket);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::updateServiceTicketViaCompanyId
     */
    public function testUpdateServiceTicketViaCompanyIdReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->updateServiceTicketViaCompanyId('ConnectWise', $this->validTicketDataArray);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::updateTicketNote
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testUpdateTicketNoteThrowsExceptionWhenMissingNoteArrayItem()
    {
        $this->fixture->updateTicketNote(array('Id' => 1406, 'NoteType' => 'Comment'), 5);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::updateTicketNote
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testUpdateTicketNoteThrowsExceptionOnRecIdNotFound()
    {
        $this->fixture->updateTicketNote(array(
            'Id' => 1406, 'NoteType' => 'Comment', 'NoteText' => 'shoes is for shoes', 'IsFlagged' => false, 'PortalIsInternalNote' => false,
            'PortalIsExternalNote' => false, 'IsPartOfDetailDescription' => false, 'IsPartOfInternalAnalysis' => true, 
            'IsPartOfResolution' => false, 'MemberRecID' => 0, 'ContactRecID' => 0, 'DateCreated' => '2013-05-10'
        ), 99990);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::updateTicketNote
     */
    public function testUpdateTicketNoteReturnsPopulatedArrayOnSuccess()
    {
        $result = $this->fixture->updateTicketNote(array(
            'Id' => 1406, 'NoteType' => 'Comment', 'NoteText' => 'shoes is for shoes', 'IsFlagged' => false, 'PortalIsInternalNote' => false,
            'PortalIsExternalNote' => false, 'IsPartOfDetailDescription' => false, 'IsPartOfInternalAnalysis' => true, 
            'IsPartOfResolution' => false, 'MemberRecID' => 0, 'ContactRecID' => 0, 'DateCreated' => '2013-05-10'
        ), 5);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::updateTicketProduct
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testUpdateTicketProductThrowsExceptionForIncompleteDataArray()
    {
        $tempProductArray = $this->validTicketProductArray;

        unset($tempProductArray['TicketId']);
        unset($tempProductArray['ItemId']);

        $this->fixture->updateTicketProduct($tempProductArray);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::updateTicketProduct
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testUpdateTicketProductThrowsExceptionForInvalidArrayItem()
    {
        $tempProductArray = $this->validTicketProductArray;

        $tempProductArray['TicketId'] = 99099;
        $tempProductArray['ItemId'] = 99099;

        $this->fixture->updateTicketProduct($tempProductArray);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::updateTicketProduct
     */
    public function testUpdateTicketProductReturnsPopulatedArrayOnSuccess()
    {
        $product = $this->validTicketProductArray;
        $product['Id'] = 27;
        $product['TicketId'] = 960;

        $result = $this->fixture->updateTicketProduct($product);

        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::deleteTicketDocument
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteTicketDocumentThrowsExceptionOnNonIntegerParams()
    {
        $this->fixture->deleteTicketDocument('should_be_integer', 'should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::deleteTicketDocument
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteTicketDocumentThrowsExceptionOnRecordNotFound()
    {
        $this->fixture->deleteTicketDocument(99099, 99099);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::deleteTicketDocument
     */
    /*
    public function testDeleteTicketDocumentReturnsEmptyArrayOnSuccessDelete()
    {
        $result = $this->fixture->deleteTicketDocument(873, 265);

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }
    */

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::deleteTicketProduct
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteTicketProductThrowsExceptionIfParamsNonIntegers()
    {
        $this->fixture->deleteTicketProduct('should_be_integer', 'should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::deleteTicketProduct
     */
    public function testDeleteTicketProductReturnsEmptyArrayIfTicketOrProductIdInvalid()
    {
        $result = $this->fixture->deleteTicketProduct(99099, 99099);

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::deleteTicketProduct
     */
    public function testDeleteTicketProductReturnsEmptyArrayOnSuccessDelete()
    {
        $result = $this->fixture->deleteTicketProduct(82, 960);

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::deleteServiceTicket
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteServiceTicketThrowsExceptionIfParamNonInteger()
    {
        $this->fixture->deleteServiceTicket('should_be_integer');
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::deleteServiceTicket
     *
     * @expectedException ConnectwisePsaSdk\ApiException
     */
    public function testDeleteServiceTicketReturnsEmptyArrayIfNotFound()
    {
        $this->fixture->deleteServiceTicket(99099);
    }

    /**
     * @covers ConnectwisePsaSdk\ServiceTicket::deleteServiceTicket
     */
    public function testDeleteServiceTicketReturnsEmptyArrayOnSuccessDelete()
    {
        $result = $this->fixture->deleteServiceTicket(960);

        $this->assertTrue(is_array($result));
        $this->assertEquals(0, count($result));
    }
}