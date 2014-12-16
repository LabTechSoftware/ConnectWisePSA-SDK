<?php namespace LabtechSoftware\ConnectwisePsaSdk;

class DocumentIntegrationTest extends PsaTestCase
{
    protected $configuration;
    protected $factory;
    protected $fixture;

    protected function setUp()
    {
        $this->configuration = parent::setUp();
        $this->configuration['url']['cw_api_main'] = 'https://%s/v4_6_release/apis/2.0/%s.asmx?wsdl';
        $this->factory = new ConnectwiseApiFactory();
        $this->fixture = $this->factory->make('Document', $this->configuration);
    }

    public function testAddDocument()
    {
        $objectId = 1176;
        $documentTableReference = 'Ticket';
        $data = [
            'Id' => 0,
            'Title' => 'integration_test_file',
            'FileName' => 'integration_test_file.txt',
            'LastUpdated' => '2014-12-11',
            'IsLink' => false,
            'IsImage' => false,
            'IsPublic' => true,
            'Content' => 'VGhpcyBpcyBhIGZpbGUgZm9yIGludGVncmF0aW9uIHRlc3Rpbmcu'
        ];

        $results = $this->fixture->addDocuments($objectId, $documentTableReference, [$data]);
        $this->assertInternalType('object', $results->AddDocumentsResult);
        $this->assertDocumentStructure($data, $results->AddDocumentsResult->DocumentInfo);

        return ['ID' =>$results->AddDocumentsResult->DocumentInfo->Id, 'Data' => $data];
    }

    public function testAddDocumentAsLink()
    {
        $objectId = 1176;
        $documentTableReference = 'Ticket';
        $data = [
            'Id' => 0,
            'Title' => 'http://pastebin.com/raw.php?i=vu43mBRF',
            'FileName' => 'http://pastebin.com/raw.php?i=vu43mBRF',
            'LastUpdated' => '2014-12-11',
            'IsLink' => true,
            'IsImage' => false,
            'IsPublic' => true
        ];

        $results = $this->fixture->addDocuments($objectId, $documentTableReference, [$data]);
        $this->assertInternalType('object', $results->AddDocumentsResult);
        $this->assertDocumentStructure($data, $results->AddDocumentsResult->DocumentInfo, false);
    }

    /**
     * @depends testAddDocument
     * @param $res
     */
    public function testGetDocument($res)
    {
        $results = $this->fixture->getDocument($res['ID']);

        $this->assertDocumentStructure($res['Data'], $results->GetDocumentResult);
    }

    private function assertDocumentStructure($data, $result, $withContent = true)
    {
        $this->assertInternalType('object', $result);
        $this->assertInternalType('integer', $result->Id);
        if (isset($result->Title)) {
            $this->assertSame($data['Title'], $result->Title);
        }
        $this->assertSame($data['FileName'], $result->FileName);
        $this->assertNotFalse(strtotime($result->LastUpdated));
        $this->assertSame($data['IsLink'], $result->IsLink);
        $this->assertSame($data['IsImage'], $result->IsImage);
        $this->assertSame($data['IsPublic'], $result->IsPublic);
        if ($withContent === true) {
            $this->assertSame($data['Content'], $result->Content);
        }
    }
}
