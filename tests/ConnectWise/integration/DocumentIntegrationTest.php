<?php

use LabtechSoftware\ConnectwisePsaSdk\ApiException;
use LabtechSoftware\ConnectwisePsaSdk\ConnectwiseApiFactory;

class DocumentIntegrationTest extends PsaTestCase
{
    protected $fixture;

    protected function setUp()
    {
        $configArray = parent::setUp();
        $configArray['url']['cw_api_main'] = 'https://%s/v4_6_release/apis/2.0/%s.asmx?wsdl';

        $factory = new ConnectwiseApiFactory();
        $this->fixture = $factory->make('Document', $configArray);
    }


    public function testAddDocuments()
    {
        $params = [
            'objectId' => 1167,
            'documentTableReference' => 'Ticket',
            'documentInfo' => [
                'Id' => 0,
                'Title' => "install_wiz_end_points",
                "FileName" => "install_wiz_end_points.txt",
                "LastUpdated" => "2014-10-10",
                "IsLink" => false,
                "IsImage" => false,
                "IsPublic" => false,
                "Content" => "U29tZSByYW5kb20gdGV4dA=="
            ]
        ];

        $document = $this->fixture->addDocuments(
            $params['objectId'],
            $params['documentTableReference'],
            [$params['documentInfo']]
        );

        $this->assertInternalType('object', $document);
        $this->assertInternalType('object', $document->AddDocumentsResult);
        $this->assertInternalType('object', $document->AddDocumentsResult->DocumentInfo);
        $this->assertInternalType('integer', $document->AddDocumentsResult->DocumentInfo->Id);
        $this->assertInternalType('string', $document->AddDocumentsResult->DocumentInfo->Title);
        $this->assertInternalType('string', $document->AddDocumentsResult->DocumentInfo->FileName);
        $this->assertInternalType('string', $document->AddDocumentsResult->DocumentInfo->ServerFileName);
        $this->assertInternalType('string', $document->AddDocumentsResult->DocumentInfo->Path);
        $this->assertInternalType('string', $document->AddDocumentsResult->DocumentInfo->LastUpdated);
        $this->assertInternalType('boolean', $document->AddDocumentsResult->DocumentInfo->IsLink);
        $this->assertInternalType('boolean', $document->AddDocumentsResult->DocumentInfo->IsImage);
        $this->assertInternalType('boolean', $document->AddDocumentsResult->DocumentInfo->IsPublic);
        $this->assertInternalType('string', $document->AddDocumentsResult->DocumentInfo->Content);

        return $document->AddDocumentsResult->DocumentInfo->Id;
    }

    /**
     * @depends testAddDocuments
     */
    public function testGetDocument($documentId)
    {
        $document = $this->fixture->getDocument($documentId);
        $this->assertInternalType('object', $document);
        $this->assertInternalType('object', $document->GetDocumentResult);
        $this->assertInternalType('integer', $document->GetDocumentResult->Id);
        $this->assertInternalType('string', $document->GetDocumentResult->FileName);
        $this->assertInternalType('string', $document->GetDocumentResult->LastUpdated);
        $this->assertInternalType('boolean', $document->GetDocumentResult->IsLink);
        $this->assertInternalType('boolean', $document->GetDocumentResult->IsImage);
        $this->assertInternalType('boolean', $document->GetDocumentResult->IsPublic);
        $this->assertInternalType('string', $document->GetDocumentResult->Content);
    }
}