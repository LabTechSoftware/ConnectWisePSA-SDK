<?php namespace LabtechSoftware\ConnectwisePsaSdk;

class ServiceTicketIntegrationTest extends PsaTestCase
{
    protected $configuration;
    protected $factory;
    protected $fixture;
    protected $company;

    protected function setUp()
    {
        $this->configuration = parent::setUp();
        $this->factory = new ConnectwiseApiFactory();
        $this->fixture = $this->factory->make('ServiceTicket', $this->configuration);
        $this->company = $this->factory->make('Company', $this->configuration);
        $docConfig = $this->configuration;
        $docConfig['url']['cw_api_main'] = 'https://%s/v4_6_release/apis/2.0/%s.asmx?wsdl';
        $this->document = $this->factory->make('Document', $docConfig);
    }

    public function testAddCompany()
    {
        $data = [
            'DefaultAddress' => [
                'Id' => 0,
                'DefaultFlag' => true,
                'InactiveFlag' => false,
                'CompanyRecid' => 0,
                'SiteName' => 'US Headquarters'
            ],
            'CompanyName' => 'Integration Test Co.',
            'CompanyID' => 'Integrate' . time(),
            'PhoneNumber' => '8135555555',
            'FaxNumber' => '8135551111',
            'WebSite' => 'http://pandora.com',
            'Id' => 0
        ];

        $results = $this->company->addOrUpdateCompany($data)->AddOrUpdateCompanyResult;

        return [
            'ID' => $results->Id,
            'CompanyID' => $data['CompanyID']
        ];
    }

    /**
     * @depends testAddCompany
     * @param $company
     */
    public function testAddServiceTicketViaCompanyId($company)
    {
        $data = [
            'TicketNumber' => 0,
            'SendingSrServiceRecid' => 0,
            'DateReq' => '2014-12-12',
            'SubBillingMethodId' => 'None',
            'SubBillingAmount' => '99.99',
            'SubDateAccepted' => '2014-12-12',
            'SubDateAcceptedUtc' => '2014-12-12',
            'BudgetHours' => '3.00',
            'SkipCallback' => false,
            'Approved' => false,
            'ClosedFlag' => false,
            'Summary' => 'Test Ticket: Integration Testing',
            'Status' => 'N',
            'ProcessNotifications' => true
        ];

        $results = $this->fixture->addOrUpdateServiceTicketViaCompanyId($company['CompanyID'], $data);
        $this->assertInternalType('object', $results);
        $result = $results->AddOrUpdateServiceTicketViaCompanyIdResult;
        $this->assertInternalType('object', $result);
        $this->assertInternalType('integer', $result->TicketNumber);
        $this->assertSame($data['Summary'], $result->Summary);
        $this->assertInternalType('string', $result->SiteName);
        $this->assertInternalType('string', $result->Board);
        $this->assertSame($data['Status'], $result->Status);
        $this->assertInternalType('string', $result->StatusName);
        $this->assertInternalType('string', $result->AddressLine1);
        $this->assertInternalType('string', $result->AddressLine2);
        $this->assertInternalType('string', $result->City);
        $this->assertInternalType('string', $result->StateId);
        $this->assertInternalType('string', $result->Zip);
        $this->assertInternalType('string', $result->Country);
        $this->assertInternalType('string', $result->Resolution);
        $this->assertInternalType('string', $result->RemoteInternalCompanyName);
        $this->assertInternalType('string', $result->ProblemDescription);
        $this->assertInternalType('integer', $result->SendingSrServiceRecid);
        $this->assertNotFalse(strtotime($result->DateReq));
        $this->assertInternalType('string', $result->SubBillingMethodId);
        $this->assertInternalType('string', $result->SubBillingAmount);
        $this->assertNotFalse(strtotime($result->SubDateAccepted));
        $this->assertNotFalse(strtotime($result->SubDateAcceptedUtc));
        $this->assertInternalType('string', $result->CustupdateFlag);
        $this->assertInternalType('string', $result->ContactName);
        $this->assertInternalType('string', $result->ContactPhoneNumber);
        $this->assertInternalType('string', $result->ContactPhoneExtension);
        $this->assertInternalType('string', $result->ContactEmailAddress);
        $this->assertInternalType('string', $result->XRefID);
        $this->assertInternalType('object', $result->Configurations);
        $this->assertInternalType('string', $result->Location);
        $this->assertSame($data['BudgetHours'], $result->BudgetHours);
        $this->assertInternalType('string', $result->Priority);
        $this->assertSame($data['ProcessNotifications'], $result->ProcessNotifications);
        $this->assertSame($data['SkipCallback'], $result->SkipCallback);
        $this->assertInternalType('string', $result->PoNumber);
        $this->assertInternalType('string', $result->Source);
        $this->assertNull($result->OpportunityId);
        $this->assertNull($result->AgreementId);
        $this->assertNull($result->TeamId);
        $this->assertInternalType('string', $result->Severity);
        $this->assertInternalType('string', $result->Impact);
        $this->assertInternalType('object', $result->DetailNotes);
        $this->assertInternalType('object', $result->InternalAnalysisNotes);
        $this->assertInternalType('object', $result->ResolutionNotes);
        $this->assertInternalType('object', $result->TaskItems);
        $this->assertInternalType('object', $result->Documents);
        $this->assertNotFalse(strtotime($result->LastUpdateDate));
        $this->assertNull($result->ActualHours);
        $this->assertInternalType('integer', $result->BoardID);
        $this->assertNotFalse(strtotime($result->EnteredDate));
        $this->assertNotFalse(strtotime($result->ClosedDate));
        $this->assertInternalType('integer', $result->CompanyRecId);
        $this->assertInternalType('integer', $result->ContactRecId);
        $this->assertSame($company['CompanyID'], $result->CompanyId);
        $this->assertInternalType('integer', $result->PortalTypeId);
        $this->assertInternalType('boolean', $result->Approved);
        $this->assertNotFalse(strtotime($result->RequiredDate));
        $this->assertNotFalse(strtotime($result->DateReqUtc));
        $this->assertInternalType('boolean', $result->ClosedFlag);

        return $results->AddOrUpdateServiceTicketViaCompanyIdResult->TicketNumber;
    }

    /**
     * @depends testAddCompany
     * @depends testAddServiceTicketViaCompanyId
     * @param $company
     * @param $ticketNumber
     */
    public function testUpdateServiceTicketViaCompanyId($company, $ticketNumber)
    {
        $data = [
            'TicketNumber' => $ticketNumber,
            'SendingSrServiceRecid' => 99,
            'DateReq' => '2014-12-12',
            'SubBillingMethodId' => 'None',
            'SubBillingAmount' => '99.99',
            'SubDateAccepted' => '2014-12-12',
            'SubDateAcceptedUtc' => '2014-12-12',
            'BudgetHours' => '3.00',
            'SkipCallback' => false,
            'Approved' => false,
            'ClosedFlag' => false,
            'Summary' => 'Test Ticket: Integration Testing',
            'Status' => 'N',
            'ProcessNotifications' => 'Notify for you',
        ];

        $results = $this->fixture->addOrUpdateServiceTicketViaCompanyId($company['CompanyID'], $data);
        $this->assertInternalType('object', $results);
        $result = $results->AddOrUpdateServiceTicketViaCompanyIdResult;
        $this->assertInternalType('object', $result);
        $this->assertSame($ticketNumber, $result->TicketNumber);
        $this->assertSame($data['Summary'], $result->Summary);
        $this->assertInternalType('string', $result->SiteName);
        $this->assertInternalType('string', $result->Board);
        $this->assertSame($data['Status'], $result->Status);
        $this->assertInternalType('string', $result->StatusName);
        $this->assertInternalType('string', $result->AddressLine1);
        $this->assertInternalType('string', $result->AddressLine2);
        $this->assertInternalType('string', $result->City);
        $this->assertInternalType('string', $result->StateId);
        $this->assertInternalType('string', $result->Zip);
        $this->assertInternalType('string', $result->Country);
        $this->assertInternalType('string', $result->Resolution);
        $this->assertInternalType('string', $result->RemoteInternalCompanyName);
        $this->assertInternalType('string', $result->ProblemDescription);
        $this->assertInternalType('integer', $result->SendingSrServiceRecid);
        $this->assertNotFalse(strtotime($result->DateReq));
        $this->assertInternalType('string', $result->SubBillingMethodId);
        $this->assertInternalType('string', $result->SubBillingAmount);
        $this->assertNotFalse(strtotime($result->SubDateAccepted));
        $this->assertNotFalse(strtotime($result->SubDateAcceptedUtc));
        $this->assertInternalType('string', $result->CustupdateFlag);
        $this->assertInternalType('string', $result->ContactName);
        $this->assertInternalType('string', $result->ContactPhoneNumber);
        $this->assertInternalType('string', $result->ContactPhoneExtension);
        $this->assertInternalType('string', $result->ContactEmailAddress);
        $this->assertInternalType('string', $result->XRefID);
        $this->assertInternalType('object', $result->Configurations);
        $this->assertInternalType('string', $result->Location);
        $this->assertSame($data['BudgetHours'], $result->BudgetHours);
        $this->assertInternalType('string', $result->Priority);
        $this->assertInternalType('boolean', $result->ProcessNotifications);
        $this->assertSame($data['SkipCallback'], $result->SkipCallback);
        $this->assertInternalType('string', $result->PoNumber);
        $this->assertInternalType('string', $result->Source);
        $this->assertNull($result->OpportunityId);
        $this->assertNull($result->AgreementId);
        $this->assertNull($result->TeamId);
        $this->assertInternalType('string', $result->Severity);
        $this->assertInternalType('string', $result->Impact);
        $this->assertInternalType('object', $result->DetailNotes);
        $this->assertInternalType('object', $result->InternalAnalysisNotes);
        $this->assertInternalType('object', $result->ResolutionNotes);
        $this->assertInternalType('object', $result->TaskItems);
        $this->assertInternalType('object', $result->Documents);
        $this->assertNotFalse(strtotime($result->LastUpdateDate));
        $this->assertNull($result->ActualHours);
        $this->assertInternalType('integer', $result->BoardID);
        $this->assertNotFalse(strtotime($result->EnteredDate));
        $this->assertNotFalse(strtotime($result->ClosedDate));
        $this->assertInternalType('integer', $result->CompanyRecId);
        $this->assertInternalType('integer', $result->ContactRecId);
        $this->assertSame($company['CompanyID'], $result->CompanyId);
        $this->assertInternalType('integer', $result->PortalTypeId);
        $this->assertInternalType('boolean', $result->Approved);
        $this->assertNotFalse(strtotime($result->RequiredDate));
        $this->assertNotFalse(strtotime($result->DateReqUtc));
        $this->assertInternalType('boolean', $result->ClosedFlag);
    }

    public function testAddServiceTicketViaManagedId()
    {

    }

    public function testUpdateServiceTicketViaManagedId()
    {

    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @param $ticketNumber
     */
    public function testAddTicketProduct($ticketNumber)
    {
        $data = [
            'Dropship' => false,
            'SpecialOrder' => false,
            'ForecastDetailId' => 0,
            'TicketId' => $ticketNumber,
            'ProjectId' => 0,
            'InvoiceId' => 0,
            'SalesOrderId' => 0,
            'Price' => 5.0,
            'Cost' => 0.0,
            'Quantity' => 3.00,
            'ItemId' => 743,
            'Description' => 'Test Product',
            'Invoice' => false,
            'Taxable' => false,
            'Billable' => false,
            'Id' => 0,
            'OpportunityId' => 0,
            'OwnerLevelRecid' => 2,
            'Warehouse' => false,
            'Bin' => false,
            'BillingUnitRecid' => 10,
            'SequenceNumber' => 1
        ];

        $results = $this->fixture->addOrUpdateTicketProduct($data);
        $this->assertInternalType('object', $results);
        $result = $results->AddOrUpdateTicketProductResult;
        $this->assertInternalType('object', $result);
        $this->assertSame($data['Dropship'], $result->Dropship);
        $this->assertSame($data['SpecialOrder'], $result->SpecialOrder);
        $this->assertSame($data['ForecastDetailId'], $result->ForecastDetailId);
        $this->assertSame($data['TicketId'], $result->TicketId);
        $this->assertSame($data['ProjectId'], $result->ProjectId);
        $this->assertSame($data['InvoiceId'], $result->InvoiceId);
        $this->assertSame($data['SalesOrderId'], $result->SalesOrderId);
        $this->assertSame($data['Invoice'], $result->Invoice);
        $this->assertSame($data['Taxable'], $result->Taxable);
        $this->assertSame($data['Billable'], $result->Billable);
        $this->assertInternalType('string', $result->Price);
        $this->assertInternalType('string', $result->Cost);
        $this->assertInternalType('string', $result->Quantity);
        $this->assertInternalType('integer', $result->ItemId);
        $this->assertSame($data['Description'], $result->Description);
        $this->assertInternalType('integer', $result->Id);
        $this->assertSame($data['OpportunityId'], $result->OpportunityId);
        $this->assertInternalType('string', $result->Warehouse);
        $this->assertInternalType('string', $result->Bin);
        $this->assertSame($data['OwnerLevelRecid'], $result->OwnerLevelRecid);
        $this->assertSame($data['BillingUnitRecid'], $result->BillingUnitRecid);
        $this->assertInternalType('string', $result->SequenceNumber);
        $this->assertInternalType('object', $result->BundleComponents);

        return $results->AddOrUpdateTicketProductResult->Id;
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @depends testAddTicketProduct
     * @param $ticketNumber
     * @param $productID
     */
    public function testUpdateTicketProduct($ticketNumber, $productID)
    {
        $data = [
            'Dropship' => false,
            'SpecialOrder' => false,
            'ForecastDetailId' => 0,
            'TicketId' => $ticketNumber,
            'ProjectId' => 0,
            'InvoiceId' => 0,
            'SalesOrderId' => 0,
            'Price' => 5.0,
            'Cost' => 0.0,
            'Quantity' => 3.00,
            'ItemId' => 743,
            'Description' => 'Test Product',
            'Invoice' => false,
            'Taxable' => false,
            'Billable' => false,
            'Id' => $productID,
            'OpportunityId' => 0,
            'OwnerLevelRecid' => 2,
            'Warehouse' => false,
            'Bin' => false,
            'BillingUnitRecid' => 10,
            'SequenceNumber' => 1
        ];

        $results = $this->fixture->addOrUpdateTicketProduct($data);
        $this->assertInternalType('object', $results);
        $result = $results->AddOrUpdateTicketProductResult;
        $this->assertInternalType('object', $result);
        $this->assertSame($data['Dropship'], $result->Dropship);
        $this->assertSame($data['SpecialOrder'], $result->SpecialOrder);
        $this->assertSame($data['ForecastDetailId'], $result->ForecastDetailId);
        $this->assertSame($data['TicketId'], $result->TicketId);
        $this->assertSame($data['ProjectId'], $result->ProjectId);
        $this->assertSame($data['InvoiceId'], $result->InvoiceId);
        $this->assertSame($data['SalesOrderId'], $result->SalesOrderId);
        $this->assertSame($data['Invoice'], $result->Invoice);
        $this->assertSame($data['Taxable'], $result->Taxable);
        $this->assertSame($data['Billable'], $result->Billable);
        $this->assertInternalType('string', $result->Price);
        $this->assertInternalType('string', $result->Cost);
        $this->assertInternalType('string', $result->Quantity);
        $this->assertInternalType('integer', $result->ItemId);
        $this->assertSame($data['Description'], $result->Description);
        $this->assertInternalType('integer', $result->Id);
        $this->assertSame($data['OpportunityId'], $result->OpportunityId);
        $this->assertInternalType('string', $result->Warehouse);
        $this->assertInternalType('string', $result->Bin);
        $this->assertSame($data['OwnerLevelRecid'], $result->OwnerLevelRecid);
        $this->assertSame($data['BillingUnitRecid'], $result->BillingUnitRecid);
        $this->assertInternalType('string', $result->SequenceNumber);
        $this->assertInternalType('object', $result->BundleComponents);
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @param $ticketNumber
     */
    public function testFindServiceTickets($ticketNumber)
    {
        $results = $this->fixture->findServiceTickets(1, 0, "SRServiceRecID = {$ticketNumber}", '');
        $this->assertInternalType('object', $results);
        $result = $results->FindServiceTicketsResult;
        $this->assertInternalType('object', $result);
        $this->assertInternalType('object', $result->Ticket);
        $this->assertSame($ticketNumber, $result->Ticket->SRServiceRecID);
        $this->assertInternalType('string', $result->Ticket->CompanyName);
        $this->assertInternalType('integer', $result->Ticket->CompanyRecId);
        $this->assertInternalType('integer', $result->Ticket->ContactRecId);
        $this->assertInternalType('string', $result->Ticket->ContactName);
        $this->assertInternalType('string', $result->Ticket->AddressLine1);
        $this->assertInternalType('string', $result->Ticket->AddressLine2);
        $this->assertInternalType('string', $result->Ticket->City);
        $this->assertInternalType('string', $result->Ticket->StateId);
        $this->assertInternalType('string', $result->Ticket->Zip);
        $this->assertInternalType('string', $result->Ticket->Country);
        $this->assertInternalType('string', $result->Ticket->Board);
        $this->assertInternalType('string', $result->Ticket->BoardName);
        $this->assertInternalType('integer', $result->Ticket->BoardID);
        $this->assertInternalType('string', $result->Ticket->TicketStatus);
        $this->assertInternalType('string', $result->Ticket->StatusName);
        $this->assertInternalType('boolean', $result->Ticket->ClosedFlag);
        $this->assertInternalType('string', $result->Ticket->Type);
        $this->assertInternalType('string', $result->Ticket->Priority);
        $this->assertInternalType('string', $result->Ticket->Location);
        $this->assertInternalType('string', $result->Ticket->Source);
        $this->assertInternalType('string', $result->Ticket->Summary);
        $this->assertNotFalse(strtotime($result->Ticket->EnteredDate));
        $this->assertNotFalse(strtotime($result->Ticket->LastUpdateDate));
        $this->assertInternalType('string', $result->Ticket->Resources);
        $this->assertNotFalse(strtotime($result->Ticket->RequiredDate));
        $this->assertNull($result->Ticket->ClosedDate);
        $this->assertInternalType('string', $result->Ticket->SiteName);
        $this->assertInternalType('string', $result->Ticket->BudgetHours);
        $this->assertNull($result->Ticket->ActualHours);
        $this->assertInternalType('boolean', $result->Ticket->Approved);
        $this->assertInternalType('string', $result->Ticket->ClosedBy);
        $this->assertInternalType('integer', $result->Ticket->ResolveMins);
        $this->assertInternalType('integer', $result->Ticket->ResPlanMins);
        $this->assertInternalType('integer', $result->Ticket->RespondMins);
        $this->assertInternalType('string', $result->Ticket->UpdatedBy);
        $this->assertInternalType('string', $result->Ticket->RecordType);
        $this->assertInternalType('integer', $result->Ticket->TeamId);
        $this->assertInternalType('integer', $result->Ticket->AgreementId);
        $this->assertInternalType('string', $result->Ticket->Severity);
        $this->assertInternalType('string', $result->Ticket->Impact);
        $this->assertNull($result->Ticket->DateResolvedUTC);
        $this->assertNull($result->Ticket->DateResplanUTC);
        $this->assertNull($result->Ticket->DateRespondedUTC);
        $this->assertInternalType('string', $result->Ticket->LastUpdateId);
        $this->assertInternalType('string', $result->Ticket->ContactEmailAddress);
        $this->assertInternalType('string', $result->Ticket->SubType);
        $this->assertInternalType('string', $result->Ticket->SubTypeItem);
        $this->assertInternalType('string', $result->Ticket->ContactPhoneNumber);
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @param $ticketNumber
     */
    public function testGetServiceStatuses($ticketNumber)
    {
        $results = $this->fixture->getServiceStatuses($ticketNumber);
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->GetServiceStatusesResult);
        $this->assertInternalType('array', $results->GetServiceStatusesResult->string);
        foreach ($results->GetServiceStatusesResult->string as $status) {
            $this->assertInternalType('string', $status);
        }
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @param $ticketNumber
     */
    public function testGetServiceTicket($ticketNumber)
    {
        $results = $this->fixture->getServiceTicket($ticketNumber);
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->GetServiceTicketResult);
        $this->assertServiceTicketStructure($results->GetServiceTicketResult);
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @param $ticketNumber
     */
    public function testGetTicketCount($ticketNumber)
    {
        $results = $this->fixture->getTicketCount('SRServiceRecID = ' . $ticketNumber);
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->GetTicketCountResult);
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @param $ticketNumber
     */
    public function testGetTicketProductList($ticketNumber)
    {
        $results = $this->fixture->getTicketProductList($ticketNumber);
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->GetTicketProductListResult);
        $this->assertInternalType('object', $results->GetTicketProductListResult->TicketProduct);
        $this->assertInternalType('boolean', $results->GetTicketProductListResult->TicketProduct->Dropship);
        $this->assertInternalType('boolean', $results->GetTicketProductListResult->TicketProduct->SpecialOrder);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->ForecastDetailId);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->TicketId);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->ProjectId);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->InvoiceId);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->SalesOrderId);
        $this->assertInternalType('boolean', $results->GetTicketProductListResult->TicketProduct->Invoice);
        $this->assertInternalType('boolean', $results->GetTicketProductListResult->TicketProduct->Taxable);
        $this->assertInternalType('boolean', $results->GetTicketProductListResult->TicketProduct->Billable);
        $this->assertInternalType('string', $results->GetTicketProductListResult->TicketProduct->Price);
        $this->assertInternalType('string', $results->GetTicketProductListResult->TicketProduct->Cost);
        $this->assertInternalType('string', $results->GetTicketProductListResult->TicketProduct->Quantity);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->ItemId);
        $this->assertInternalType('string', $results->GetTicketProductListResult->TicketProduct->Description);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->Id);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->OpportunityId);
        $this->assertInternalType('string', $results->GetTicketProductListResult->TicketProduct->Warehouse);
        $this->assertInternalType('string', $results->GetTicketProductListResult->TicketProduct->Bin);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->OwnerLevelRecid);
        $this->assertInternalType('integer', $results->GetTicketProductListResult->TicketProduct->BillingUnitRecid);
        $this->assertInternalType('string', $results->GetTicketProductListResult->TicketProduct->SequenceNumber);
        $this->assertInternalType('object', $results->GetTicketProductListResult->TicketProduct->BundleComponents);
    }

    public function testSearchKnowledgebase()
    {
        $results = $this->fixture->searchKnowledgebase('', 'Any', '2014-12-12', 0, 0, 0);
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->SearchKnowledgebaseResult);
        $this->assertInternalType('array', $results->SearchKnowledgebaseResult->KnowledgeBaseResult);
        foreach ($results->SearchKnowledgebaseResult->KnowledgeBaseResult as $result) {
            $this->assertInternalType('object', $result);
            $this->assertInternalType('integer', $result->SRServiceRecID);
            $this->assertInternalType('string', $result->CompanyName);
            $this->assertInternalType('string', $result->ContactName);
            $this->assertInternalType('string', $result->AddressLine1);
            $this->assertInternalType('string', $result->AddressLine2);
            $this->assertInternalType('string', $result->City);
            $this->assertInternalType('string', $result->StateId);
            $this->assertInternalType('string', $result->Zip);
            $this->assertInternalType('string', $result->Country);
            $this->assertInternalType('string', $result->Board);
            $this->assertInternalType('string', $result->BoardName);
            $this->assertInternalType('string', $result->TicketStatus);
            $this->assertInternalType('string', $result->StatusName);
            $this->assertInternalType('boolean', $result->ClosedFlag);
            $this->assertInternalType('string', $result->Type);
            $this->assertInternalType('string', $result->Priority);
            $this->assertInternalType('string', $result->Location);
            $this->assertInternalType('string', $result->Source);
            $this->assertInternalType('string', $result->Summary);
            $this->assertInternalType('string', $result->DetailDescription);
            $this->assertInternalType('string', $result->InternalNotes);
            $this->assertInternalType('string', $result->Resolution);
            $this->assertNotFalse(strtotime($result->EnteredDate));
            $this->assertNotFalse(strtotime($result->LastUpdateDate));
            $this->assertNotFalse(strtotime($result->RequiredDate));
            $this->assertNotFalse(strtotime($result->ClosedDate));
            $this->assertInternalType('string', $result->SiteName);
            $this->assertInternalType('string', $result->BudgetHours);
            $this->assertInternalType('string', $result->ActualHours);
            $this->assertInternalType('boolean', $result->Approved);
            $this->assertInternalType('integer', $result->BoardID);
            $this->assertInternalType('integer', $result->CompanyRecId);
            $this->assertInternalType('integer', $result->ContactRecId);
            $this->assertInternalType('string', $result->UpdatedBy);
            $this->assertInternalType('boolean', $result->EmergencyFlag);
        }
    }

    public function testSearchKnowledgebaseCount()
    {
        $results = $this->fixture->searchKnowledgebaseCount('', 'Any', '2014-12-12', 0);
        $this->assertInternalType('object', $results);
        $this->assertInternalType('integer', $results->SearchKnowledgebaseCountResult);
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @param $ticketNumber
     */
    public function testGetTicketDocuments($ticketNumber)
    {
        $objectId = $ticketNumber;
        $documentTableReference = 'Ticket';
        $data = [
            'Id' => 0,
            'Title' => 'integration_test_file',
            'FileName' => 'integration_test_file.txt',
            'LastUpdated' => '2014-12-11',
            'IsLink' => false,
            'IsImage' => false,
            'IsPublic' => false,
            'Content' => 'VGhpcyBpcyBhIGZpbGUgZm9yIGludGVncmF0aW9uIHRlc3Rpbmcu'
        ];

        $addResults = $this->document->addDocuments($objectId, $documentTableReference, [$data]);

        $results = $this->fixture->getTicketDocuments($ticketNumber);

        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->GetTicketDocumentsResult);
        $this->assertInternalType('object', $results->GetTicketDocumentsResult->DocumentInfo);
        $this->assertInternalType('integer', $results->GetTicketDocumentsResult->DocumentInfo->Id);
        $this->assertSame($data['Title'], $results->GetTicketDocumentsResult->DocumentInfo->Title);
        $this->assertSame($data['FileName'], $results->GetTicketDocumentsResult->DocumentInfo->FileName);
        $this->assertInternalType('string', $results->GetTicketDocumentsResult->DocumentInfo->ServerFileName);
        $this->assertInternalType('string', $results->GetTicketDocumentsResult->DocumentInfo->Path);
        $this->assertNotFalse(strtotime($results->GetTicketDocumentsResult->DocumentInfo->LastUpdated));
        $this->assertInternalType('string', $results->GetTicketDocumentsResult->DocumentInfo->Owner);
        $this->assertSame($data['IsLink'], $results->GetTicketDocumentsResult->DocumentInfo->isLink);
        $this->assertSame($data['IsImage'], $results->GetTicketDocumentsResult->DocumentInfo->isImage);
        $this->assertSame($data['IsPublic'], $results->GetTicketDocumentsResult->DocumentInfo->IsPublic);
        $this->assertInternalType('string', $results->GetTicketDocumentsResult->DocumentInfo->ChildDesc);

        return $results->GetTicketDocumentsResult->DocumentInfo->Id;
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @param $ticketNumber
     */
    public function testUpdateTicketNote($ticketNumber)
    {
        $data = array(
            'CustomerUpdatedFlag' => true,
            'ProcessNotifications' => true,
            'Id' => 0,
            'PortalIsInternalNote' => false,
            'PortalIsExternalNote' => false,
            'IsPartOfDetailDescription' => true,
            'IsPartOfInternalAnalysis' => false,
            'IsPartOfResolution' => true,
            'MemberRecID' => 0,
            'ContactRecID' => 0,
            'NoteText' => 'Integration testing is happening!'
        );

        $results = $this->fixture->updateTicketNote($data, $ticketNumber);
        $this->assertInternalType('object', $results);
        $this->assertInternalType('object', $results->UpdateTicketNoteResult);
        $this->assertSame($data['ProcessNotifications'], $results->UpdateTicketNoteResult->ProcessNotifications);
        $this->assertInternalType('integer', $results->UpdateTicketNoteResult->Id);
        $this->assertSame($data['NoteText'], $results->UpdateTicketNoteResult->NoteText);
        $this->assertSame($data['PortalIsInternalNote'], $results->UpdateTicketNoteResult->PortalIsInternalNote);
        $this->assertSame($data['PortalIsExternalNote'], $results->UpdateTicketNoteResult->PortalIsExternalNote);
        $this->assertInternalType('boolean', $results->UpdateTicketNoteResult->CustomerUpdatedFlag);
        $this->assertSame($data['IsPartOfDetailDescription'], $results->UpdateTicketNoteResult->IsPartOfDetailDescription);
        $this->assertSame($data['IsPartOfInternalAnalysis'], $results->UpdateTicketNoteResult->IsPartOfInternalAnalysis);
        $this->assertSame($data['IsPartOfResolution'], $results->UpdateTicketNoteResult->IsPartOfResolution);
        $this->assertSame($data['MemberRecID'], $results->UpdateTicketNoteResult->MemberRecID);
        $this->assertSame($data['ContactRecID'], $results->UpdateTicketNoteResult->ContactRecID);
        $this->assertNull($results->UpdateTicketNoteResult->DateCreated);
        $this->assertNull($results->UpdateTicketNoteResult->DateCreatedUtc);
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @depends testAddTicketProduct
     * @param $ticketNumber
     * @param $productID
     */
    public function testDeleteTicketProduct($ticketNumber, $productID)
    {
        $results = $this->fixture->deleteTicketProduct($productID, $ticketNumber);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @depends testGetTicketDocuments
     * @param $ticketNumber
     * @param $documentID
     */
    public function testDeleteDocument($ticketNumber, $documentID)
    {
        $results = $this->fixture->deleteTicketDocument($documentID, $ticketNumber);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @depends testAddServiceTicketViaCompanyId
     * @param $ticketNumber
     */
    public function testDeleteServiceTicket($ticketNumber)
    {
        $results = $this->fixture->deleteServiceTicket($ticketNumber);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @depends testAddCompany
     * @param $res
     */
    public function testDeleteCompany($res)
    {
        $results = $this->company->deleteCompany($res['ID']);
        $this->assertInternalType('object', $results);
        $this->assertTrue(empty((array)$results));
    }

    /**
     * @param $result
     */
    private function assertServiceTicketStructure($result)
    {
        $this->assertInternalType('integer', $result->TicketNumber);
        $this->assertInternalType('string', $result->Summary);
        $this->assertInternalType('string', $result->SiteName);
        $this->assertInternalType('string', $result->Board);
        $this->assertInternalType('string', $result->Status);
        $this->assertInternalType('string', $result->StatusName);
        $this->assertInternalType('string', $result->AddressLine1);
        $this->assertInternalType('string', $result->AddressLine2);
        $this->assertInternalType('string', $result->City);
        $this->assertInternalType('string', $result->StateId);
        $this->assertInternalType('string', $result->Zip);
        $this->assertInternalType('string', $result->Country);
        $this->assertInternalType('string', $result->Resolution);
        $this->assertInternalType('string', $result->RemoteInternalCompanyName);
        $this->assertInternalType('string', $result->ProblemDescription);
        $this->assertInternalType('integer', $result->SendingSrServiceRecid);
        $this->assertNotFalse(strtotime($result->DateReq));
        $this->assertInternalType('string', $result->SubBillingMethodId);
        $this->assertInternalType('string', $result->SubBillingAmount);
        $this->assertNotFalse(strtotime($result->SubDateAccepted));
        $this->assertNotFalse(strtotime($result->SubDateAcceptedUtc));
        $this->assertInternalType('string', $result->CustupdateFlag);
        $this->assertInternalType('string', $result->ContactName);
        $this->assertInternalType('string', $result->ContactPhoneNumber);
        $this->assertInternalType('string', $result->ContactPhoneExtension);
        $this->assertInternalType('string', $result->ContactEmailAddress);
        $this->assertInternalType('string', $result->XRefID);
        $this->assertInternalType('object', $result->Configurations);
        $this->assertInternalType('string', $result->Location);
        $this->assertInternalType('string', $result->BudgetHours);
        $this->assertInternalType('string', $result->Priority);
        $this->assertInternalType('boolean', $result->ProcessNotifications);
        $this->assertInternalType('boolean', $result->SkipCallback);
        $this->assertInternalType('string', $result->PoNumber);
        $this->assertInternalType('string', $result->Source);
        $this->assertNull($result->OpportunityId);
        $this->assertNull($result->AgreementId);
        $this->assertNull($result->TeamId);
        $this->assertInternalType('string', $result->Severity);
        $this->assertInternalType('string', $result->Impact);
        $this->assertInternalType('object', $result->DetailNotes);
        $this->assertInternalType('object', $result->InternalAnalysisNotes);
        $this->assertInternalType('object', $result->ResolutionNotes);
        $this->assertInternalType('object', $result->TaskItems);
        $this->assertInternalType('object', $result->Documents);
        $this->assertNotFalse(strtotime($result->LastUpdateDate));
        $this->assertInternalType('string', $result->ActualHours);
        $this->assertInternalType('integer', $result->BoardID);
        $this->assertNotFalse(strtotime($result->EnteredDate));
        $this->assertNotFalse(strtotime($result->ClosedDate));
        $this->assertInternalType('integer', $result->CompanyRecId);
        $this->assertInternalType('integer', $result->ContactRecId);
        $this->assertInternalType('string', $result->CompanyId);
        $this->assertInternalType('integer', $result->PortalTypeId);
        $this->assertInternalType('boolean', $result->Approved);
        $this->assertNotFalse(strtotime($result->RequiredDate));
        $this->assertNotFalse(strtotime($result->DateReqUtc));
        $this->assertInternalType('boolean', $result->ClosedFlag);
    }
}
