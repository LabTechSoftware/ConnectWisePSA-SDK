<?php

use LabtechSoftware\ConnectwisePsaSdk\ApiException;
use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory;

class ServiceTicketIntegrationTest extends PHPUnit_Framework_TestCase
{
    protected $fixture;

    protected static $companyID;

    protected function setUp()
    {
        $configArray = include 'src/LabtechSoftware/ConnectwisePsaSdk/config/config.php';

        if (getenv('SOAP_VERSION')) {
            $configArray['soap']['soap_version'] = trim(getenv('SOAP_VERSION'));
        }

        if (getenv('EXCEPTIONS')) {
            $configArray['soap']['exceptions'] = trim(getenv('EXCEPTIONS'));
        }

        if (getenv('TRACE')) {
            $configArray['soap']['trace'] = trim(getenv('TRACE'));
        }

        if (getenv('CACHE_WSDL')) {
            $configArray['soap']['cache_wsdl'] = trim(getenv('CACHE_WSDL'));
        }

        if (getenv('CW_API_MAIN')) {
            $configArray['url']['cw_api_main'] = trim(getenv('CW_API_MAIN'));
        }

        if (getenv('DOMAIN')) {
            $configArray['credentials']['domain'] = trim(getenv('DOMAIN'));
        } else {
            throw new ApIException('DOMAIN must be set in environment');
        }

        if (getenv('COMPANYID')) {
            $configArray['credentials']['CompanyId'] = trim(getenv('COMPANYID'));
        } else {
            throw new ApIException('COMPANYID must be set in environment');
        }

        if (getenv('INTEGRATORLOGINID')) {
            $configArray['credentials']['IntegratorLoginId'] = trim(getenv('INTEGRATORLOGINID'));
        } else {
            throw new ApIException('INTEGRATORLOGINID must be set in environment');
        }

        if (getenv('INTEGRATORPASSWORD')) {
            $configArray['credentials']['IntegratorPassword'] = trim(getenv('INTEGRATORPASSWORD'));
        } else {
            throw new ApIException('INTEGRATORPASSWORD must be set in environment');
        }


        $factory = new ConnectwiseApiFactory();
        $this->fixture = $factory->make('ServiceTicket', $configArray);
    }


    public function getCompanyAPI()
    {
        $configArray = include 'src/LabtechSoftware/ConnectwisePsaSdk/config/config.php';

        if (getenv('SOAP_VERSION')) {
            $configArray['soap']['soap_version'] = trim(getenv('SOAP_VERSION'));
        }

        if (getenv('EXCEPTIONS')) {
            $configArray['soap']['exceptions'] = trim(getenv('EXCEPTIONS'));
        }

        if (getenv('TRACE')) {
            $configArray['soap']['trace'] = trim(getenv('TRACE'));
        }

        if (getenv('CACHE_WSDL')) {
            $configArray['soap']['cache_wsdl'] = trim(getenv('CACHE_WSDL'));
        }

        if (getenv('CW_API_MAIN')) {
            $configArray['url']['cw_api_main'] = trim(getenv('CW_API_MAIN'));
        }

        if (getenv('DOMAIN')) {
            $configArray['credentials']['domain'] = trim(getenv('DOMAIN'));
        } else {
            throw new ApIException('DOMAIN must be set in environment');
        }

        if (getenv('COMPANYID')) {
            $configArray['credentials']['CompanyId'] = trim(getenv('COMPANYID'));
        } else {
            throw new ApIException('COMPANYID must be set in environment');
        }

        if (getenv('INTEGRATORLOGINID')) {
            $configArray['credentials']['IntegratorLoginId'] = trim(getenv('INTEGRATORLOGINID'));
        } else {
            throw new ApIException('INTEGRATORLOGINID must be set in environment');
        }

        if (getenv('INTEGRATORPASSWORD')) {
            $configArray['credentials']['IntegratorPassword'] = trim(getenv('INTEGRATORPASSWORD'));
        } else {
            throw new ApIException('INTEGRATORPASSWORD must be set in environment');
        }


        $factory = new ConnectwiseApiFactory();
        return $factory->make('Company', $configArray);
    }

    // this method tests:
    // 1. adding a service ticket via: ServiceTicket::addOrUpdateServiceTicketViaCompanyId
    // 2. updating a service ticket via: ServiceTicket::addOrUpdateServiceTicketViaCompanyId
    // to do this, a companyID is required, and to ensure that the companyID is valid, we will
    // first create a company via the CompanyAPI, and after we are finished testing the above mentioned
    // ServiceTicketAPI methods, we will delete the company
    public function testAddAndUpdateServiceTicketViaCompanyId()
    {
        // let's add the company first
        $companyAPI = $this->getCompanyAPI();

        // when we delete a company from the PSA, the record is still stored in the DB
        // and when we rerun our tests, we will get an error stating that the company ID is not
        // unique, use time() to make sure each time we run tests we have a unique company ID
        $randomCompanyID = 'Pandora' . time();

        $params = array(
            'DefaultAddress' => array(
                'Id' => 0,
                'DefaultFlag' => true,
                'CompanyRecid' => 0,
                'SiteName' => 'American Headquarters'
            ),
            'CompanyName' => 'Pandora IncInc.',
            'CompanyID' => $randomCompanyID,
            'PhoneNumber' => '8135555555',
            'FaxNumber' => '8135551111',
            'WebSite' => 'http://pandora.com',
            'Id' => 0
        );

        $company = $companyAPI->addOrUpdateCompany($params);
        self::$companyID = $company->AddOrUpdateCompanyResult->Id;
        $companyIDString = $company->AddOrUpdateCompanyResult->CompanyID;


        // prepare the service ticket
        $ticketData = array(
            'TicketNumber' => 0,
            'SendingSrServiceRecid' => 99,
            'DateReq' => '2014-02-27',
            'SubBillingMethodId' => 'None',
            'SubBillingAmount' => '99.99',
            'SubDateAccepted' => '2014-02-27',
            'SubDateAcceptedUtc' => '2014-02-27',
            'BudgetHours' => '3.0',
            'SkipCallback' => false,
            'Approved' => false,
            'ClosedFlag' => false,
            'Summary' => 'This be a status yo',
            'Status' => 'N',
            'ProcessNotifications' => 'Notify for you',
            'DetailNotes' => array(
                'TicketNote' => array(
                    'Id' => 1,
                    'MemberRecID' => 1,
                    'ContactRecID' => 1,
                    'NoteText' => 'test21',
                    'CustomerUpdatedFlag' => false,
                    'ProcessNotifications' => false,
                    'PortalIsInternalNote' => false,
                    'PortalIsExternalNote' => false,
                    'IsPartOfDetailDescription' => false,
                    'IsPartOfInternalAnalysis' => false,
                    'IsPartOfResolution' => false,
                )
            ),
        );

        // add the service ticket
        $serviceTicket = $this->fixture->addOrUpdateServiceTicketViaCompanyId($companyIDString, $ticketData);

        // assert
        $this->assertInternalType('object', $serviceTicket);

        // get the ticket number of the newly created ticket
        $ticketNumber = $serviceTicket->AddOrUpdateServiceTicketViaCompanyIdResult->TicketNumber;

        // update the service ticket
        $ticketData['TicketNumber'] = $ticketNumber;
        $updatedServiceTicket = $this->fixture->addOrUpdateServiceTicketViaCompanyId($companyIDString, $ticketData);

        // assert
        $this->assertInternalType('object', $updatedServiceTicket);

        return $ticketNumber;
    }


    /**
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testAddOrUpdateTicketProduct($ticketNumber)
    {
        $ticketProductData = array(
            'Dropship' => false, 'SpecialOrder' => false, 'ForecastDetailId' => 0, 'TicketId' => $ticketNumber,
            'ProjectId' => 0, 'InvoiceId' => 0, 'SalesOrderId' => 0, 'Price' => 5.0, 'Cost' => 0.0, 'Quantity' => 3.00,
            'ItemId' => 743, 'Description' => 'Test product', 'Invoice' => false, 'Taxable' => false,
            'Billable' => false, 'Id' => 0, 'OpportunityId' => 0, 'OwnerLevelRecid' => 2, 'Warehouse' => false,
            'Bin' => false, 'BillingUnitRecid' => 10, 'SequenceNumber' => 1
        );

        $response = $this->fixture->addOrUpdateTicketProduct($ticketProductData);
        $this->assertInternalType('object', $response);
        $productId = $response->AddOrUpdateTicketProductResult->Id;
        return array('TicketId' => $ticketNumber, 'ProductId' => $productId);
    }

    /**
     * @depends testAddOrUpdateTicketProduct
     */
    public function testDeleteTicketProduct($ids)
    {
        $this->assertInternalType('object', $this->fixture->deleteTicketProduct($ids['ProductId'], $ids['TicketId']));
        $this->fixture->getTicketProductList($ids['TicketId']);
    }


    /**
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testUpdateTicketNote($ticketNumber)
    {
        $noteData = array(
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
            'NoteText' => 'Who is your daddy, and what does he do?'
        );

        // create the service ticket note
        $note = $this->fixture->updateTicketNote($noteData, $ticketNumber);

        $this->assertInternalType('object', $note);
    }


    /**
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testFindServiceTickets($ticketNumber)
    {
        $ticket = $this->fixture->findServiceTickets(100, 0, 'SRServiceRecID = ' . $ticketNumber, '');

        $this->assertInternalType('object', $ticket);
    }


    /**
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testGetServiceStatuses($ticketNumber)
    {
        $this->assertInternalType('object', $this->fixture->getServiceStatuses($ticketNumber));
    }


    /**
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testGetServiceTicket($ticketNumber)
    {
        $this->assertInternalType('object', $response = $this->fixture->getServiceTicket($ticketNumber));
    }


    /**
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testGetTicketCount($ticketNumber)
    {
        $this->assertInternalType('object', $this->fixture->getTicketCount(true, 'SRServiceRecID = ' . $ticketNumber));
    }


    /**
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testGetTicketProductList($ticketNumber)
    {
        $this->assertInternalType('object', $this->fixture->getTicketProductList($ticketNumber));
    }


    public function testSearchKnowledgebase()
    {
        $this->assertInternalType('object', $this->fixture->searchKnowledgebase('', 'Any', '2014-03-10', 0, 0, 0));
    }


    public function testSearchKnowledgebaseCount()
    {
        $this->assertInternalType('object', $this->fixture->searchKnowledgebaseCount('', 'Any', '2014-03-10', 0));
    }


    /**
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testGetTicketDocuments($ticketNumber)
    {
        // TODO: Check if AddDocumentToTicket() has been implemented in the Connectwise SDK.
        // Until then we can add documents to tickets via POST upload.
        $curl = curl_init("https://test.connectwise.com/v4_6_release/services/system_io/integration_io/UploadDocumentToTicket.aspx");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'IntegrationLoginId' => 'webdev',
            'IntegrationPassword' => 'webdev',
            'PsaCompanyName' => 'LabTech',
            'SRServiceRecId' => $ticketNumber,
            'file' => '@/etc/hosts'
            )
        );
        $this->assertEquals('Document uploaded.', curl_exec($curl));

        $response = $this->fixture->getTicketDocuments($ticketNumber);
        $this->assertInternalType('object', $response);

        return $response->GetTicketDocumentsResult->DocumentInfo->Id;
    }


    /**
     * @depends testGetTicketDocuments
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testDeleteTicketDocument($documentId, $ticketNumber)
    {
        $response = $this->fixture->deleteTicketDocument($documentId, $ticketNumber);
        $this->assertInternalType('object', $response);
    }

    /**
     * @depends testAddAndUpdateServiceTicketViaCompanyId
     */
    public function testDeleteServiceTicket($ticketNumber)
    {
        $this->assertInternalType('object', $this->fixture->deleteServiceTicket($ticketNumber));
    }

    public function testDeleteCompany()
    {
        // No assertions here because we are calling another API.
        $this->getCompanyAPI()->deleteCompany(self::$companyID);
    }
}
