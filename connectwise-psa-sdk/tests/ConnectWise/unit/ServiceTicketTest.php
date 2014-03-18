<?php

use LabtechSoftware\ConnectwisePsaSdk\ServiceTicket;

/**
 * Tests for \ConnectwisePsaSdk\ServiceTicket
 * @todo Add tests for addOrUpdateServiceTicketViaManagedId, addServiceTicketViaManagedId, updateServiceTicketViaManagedId 
 *
 * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket
 */
class ServiceTicketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * ServiceTicket instance goes here
     *
     * @var LabtechSoftware\ConnectwisePsaSdk\ServiceTicket
     */
    protected $fixture;


    /**
     * Set a new ServiceTicket instance for the fixture
     */
    protected function setUp()
    {
        $client = $this->getMockBuilder('LabtechSoftware\ConnectwisePsaSdk\ConnectWiseApi')
            ->disableOriginalConstructor()
            ->getMock();

        $this->fixture = new ServiceTicket($client);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::addOrUpdateServiceTicketViaCompanyId
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateServiceTicketViaCompanyIdThrowsExceptionWhenCompanyIdIsNotAString()
    {
        $this->fixture->addOrUpdateServiceTicketViaCompanyId(3, array());
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::addOrUpdateServiceTicketViaManagedId
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testAddOrUpdateServiceTicketViaManagedIdThrowsExceptionWhenManagedIdIsNotAString()
    {
        $this->fixture->addOrUpdateServiceTicketViaManagedId(3, array());
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::findServiceTickets
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindServiceTicketsThrowsExceptionWhenLimitIsNotNumeric()
    {
        $this->fixture->findServiceTickets('', 3, '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::findServiceTickets
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindServiceTicketsThrowsExceptionWhenSkipIsNotNumeric()
    {
        $this->fixture->findServiceTickets(3, '', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::findServiceTickets
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindServiceTicketsThrowsExceptionWhenConditionsIsNotAString()
    {
        $this->fixture->findServiceTickets(3, 3, 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::findServiceTickets
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testFindServiceTicketsThrowsExceptionWhenOrderByIsNotAString()
    {
        $this->fixture->findServiceTickets(3, 3, '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::getServiceStatuses
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetServiceStatusesThrowsExceptionWhenTicketIdIsNotNumeric()
    {
        $this->fixture->getServiceStatuses('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::getServiceTicket
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetServiceTicketThrowsExceptionWhenTicketIdIsNotNumeric()
    {
        $this->fixture->getServiceTicket('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::getTicketCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetTicketCountThrowsExceptionWhenIsOpenIsNotBoolean()
    {
        $this->fixture->getTicketCount('', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::getTicketCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetTicketCountThrowsExceptionWhenConditionsIsNotAString()
    {
        $this->fixture->getTicketCount(true, 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::getTicketProductList
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetTicketProductListThrowsExceptionWhenTicketNumberIsNotNumeric()
    {
        $this->fixture->getTicketProductList('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseThrowsExceptionWhenTermsIsNotAString()
    {
        $this->fixture->searchKnowledgebase(3, 'Any', '', 3, 3, 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseThrowsExceptionWhenTypeIsNotAString()
    {
        $this->fixture->searchKnowledgebase('', 3, '', 3, 3, 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseThrowsExceptionWhenTypeIsNotAValidValue()
    {
        $this->fixture->searchKnowledgebase('', 'Not Valid String', '', 3, 3, 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseThrowsExceptionWhenStartIsNotAString()
    {
        $this->fixture->searchKnowledgebase('', 'Any', 3, 3, 3, 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseThrowsExceptionWhenCompanyRecIdIsNotNumeric()
    {
        $this->fixture->searchKnowledgebase('', 'Any', '', '', 3, 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseThrowsExceptionWhenLimitIsNotNumeric()
    {
        $this->fixture->searchKnowledgebase('', 'Any', '', 3, '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebase
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseThrowsExceptionWhenSkipIsNotNumeric()
    {
        $this->fixture->searchKnowledgebase('', 'Any', '', 3, 3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebaseCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseCountThrowsExceptionWhenTermsIsNotAString()
    {
        $this->fixture->searchKnowledgebaseCount(3, 'Any', '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebaseCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseCountThrowsExceptionWhenTypeIsNotAString()
    {
        $this->fixture->searchKnowledgebaseCount('', 3, '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebaseCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseCountThrowsExceptionWhenTypeIsNotAValidValue()
    {
        $this->fixture->searchKnowledgebaseCount('', 'Not A Valid Value', '', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebaseCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseCountThrowsExceptionWhenStartIsNotAString()
    {
        $this->fixture->searchKnowledgebaseCount('', 'Any', 3, 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::searchKnowledgebaseCount
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testSearchKnowledgebaseCountThrowsExceptionWhenCompanyRecIdIsNotNumeric()
    {
        $this->fixture->searchKnowledgebaseCount('', 'Any', '', '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::getTicketDocuments
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testGetTicketDocumentsThrowsExceptionWhenTicketNumberIsNotNumeric()
    {
        $this->fixture->getTicketDocuments('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::updateTicketNote
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testUpdateTicketNoteThrowsExceptionWhenServiceRecIdIsNotNumeric()
    {
        $this->fixture->updateTicketNote(array(), '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::deleteServiceTicket
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteServiceTicketThrowsExceptionWhenTicketIdIsNotNumeric()
    {
        $this->fixture->deleteServiceTicket('');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::deleteTicketDocument
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteTicketDocumentThrowsExceptionWhenDocIdIsNotNumeric()
    {
        $this->fixture->deleteTicketDocument('', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::deleteTicketDocument
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteTicketDocumentThrowsExceptionWhenTicketIdIsNotNumeric()
    {
        $this->fixture->deleteTicketDocument(3, '');
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::deleteTicketProduct
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteTicketProductThrowsExceptionWhenProductIdIsNotNumeric()
    {
        $this->fixture->deleteTicketProduct('', 3);
    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\ServiceTicket::deleteTicketProduct
     * @expectedException LabtechSoftware\ConnectwisePsaSdk\ApiException
     */
    public function testDeleteTicketProductThrowsExceptionWhenTicketIdIsNotNumeric()
    {
        $this->fixture->deleteTicketProduct(3, '');
    }
}
