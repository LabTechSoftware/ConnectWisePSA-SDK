<?php

use LabtechSoftware\ConnectwisePsaSdk\Document;

class DocumentTest extends PHPUnit_Framework_TestCase
{

    protected $connectWiseApiMock;
    protected $document;

    protected function setUp()
    {

        $this->connectWiseApiMock = $this->getMockBuilder('LabtechSoftware\ConnectwisePsaSdk\ConnectWiseApi')
            ->disableOriginalConstructor()
            ->getMock();

        $this->document = new Document($this->connectWiseApiMock);

    }

    protected function tearDown()
    {

//        \Mockery::close();

    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Document::addDocuments
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage objectId must be a numeric value.
     */
    public function testAddDocumentsObjectIdNotNumeric()
    {

        $this->document->addDocuments('string', null, []);

    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Document::addDocuments
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage documentTableReference must be a string value.
     */
    public function testAddDocumentsDocumentTableReferenceNotString()
    {

        $this->document->addDocuments(1, 1, []);

    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Document::addDocuments
     */
    public function testAddDocumentsObjectIdNumericDocumentTableReferenceString()
    {

        $objectId = 1;
        $documentTableReference = 'string';
        $documentInfo = ['something', 'more'];

        $this->connectWiseApiMock->expects($this->once())
            ->method('makeRequest')
            ->with(
                'AddDocuments',
                [
                    'objectId' => $objectId,
                    'documentTableReference' => $documentTableReference,
                    'documentInfo' => $documentInfo
                ]
            );

        $this->document->addDocuments(
            $objectId,
            $documentTableReference,
            $documentInfo
        );

    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Document::getDocument
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Expecting numeric value.
     */
    public function testGetDocumentDocumentIdNonNumeric()
    {

        $this->document->getDocument('string');

    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Document::getDocument
     * @expectedException        \LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @expectedExceptionMessage Expecting value greater than 0.
     */
    public function testGetDocumentDocumentIdNotGreaterThanZero()
    {

        $this->document->getDocument(0);

    }

    /**
     * @covers LabtechSoftware\ConnectwisePsaSdk\Document::getDocument
     */
    public function testGetDocumentDocumentIdNumericGreaterThanZero()
    {

        $documentId = 1;

        $this->connectWiseApiMock->expects($this->once())
            ->method('makeRequest')
            ->with('GetDocument', ['documentId' => $documentId]);

        $this->document->getDocument($documentId);

    }

}