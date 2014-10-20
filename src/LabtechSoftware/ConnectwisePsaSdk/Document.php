<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use InvalidArgumentException;

class Document
{
    /**
     * @var LabtechSoftware\ConnectwisePsaSdk\ConnectWiseApi
     */
    private $client;

    /**
     * Set API client
     *
     * @param \LabtechSoftware\ConnectwisePsaSdk\ConnectWiseApi $client
     * @return \LabtechSoftware\ConnectwisePsaSdk\Document
     */
    public function __construct(ConnectWiseApi $client)
    {
        $this->client = $client;
    }

    /**
     * Add documents to ticket
     *
     * @todo File param is string?
     * @todo Remove hard coded DocuementInfo array
     *
     * @param integer $objectId
     * @param string $documentTableReference
     * @param array $documentInfo
     * @param string $file
     * @return array
     */
    public function addDocuments($objectId, $documentTableReference, $documentInfo, $file)
    {
        $file = base64_encode(file_get_contents(base_path() . '/phpunit.xml'));

        $params = [
            'objectId' => $objectId,
            'documentTableReference' => $documentTableReference,
            'documentInfo' => [
                'DocumentInfo' => [
                    'Id' => 0,
                    'Title' => 'YourMom',
                    'FileName' => 'YourMom.xml',
                    'LastUpdated' => '2014-10-10',
                    'IsLink' => false,
                    'IsImage' => false,
                    'IsPublic' => false,
                    'Content' => $file
                ]
            ]
        ];

        // Fire off the request to the Document API and return the result array
        return $this->client->makeRequest('AddDocuments', $params);
    }

    /**
     * Retrieve a document from ConnectWise
     *
     * @throws \LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @throws \InvalidArgumentException
     * @param integer $documentId
     * @return array
     */
    public function getDocument($documentId)
    {
        // Throw exception if the argument is a non numeric value
        if (is_numeric($documentId) === false) {
            throw new InvalidArgumentException('Expecting numeric value.');
        }

        // Throw exception if the Document ID is 0 or a negative number
        if ($documentId <= 0) {
            throw new ApiException('Expecting value greater than 0.');
        }

        // Fire off the request to the Document API and return the result array
        return $this->client->makeRequest(
            'GetDocument',
            array('documentId' => $documentId)
        );
    }
}