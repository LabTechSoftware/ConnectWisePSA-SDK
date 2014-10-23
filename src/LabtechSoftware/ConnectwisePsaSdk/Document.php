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
     * Add documents to a CW object, such as a ticket or contact
     *
     * @param string|int $objectId numeric value, recID of object to add document to
     * @param string $documentTableReference type of object document is being added to
     * @param array $documentInfo array of objects that represent a document
     * @return array Array of one or more document objects
     */
    public function addDocuments($objectId, $documentTableReference, array $documentInfo)
    {
        // throw exception if $objectId is not numeric
        if (!is_numeric($objectId)) {
            throw new InvalidArgumentException(
                'objectId must be a numeric value.'
            );
        }

        // throw exception if $documentTableReference
        // is not a string
        if (!is_string($documentTableReference)) {
            throw new InvalidArgumentException(
                'documentTableReference must be a string value.'
            );
        }

        $params = [
            'objectId' => $objectId,
            'documentTableReference' => $documentTableReference,
            'documentInfo' => $documentInfo
        ];

        // Fire off the request to the Document API and return the result array
        return $this->client->makeRequest('AddDocuments', $params);
    }

    /**
     * Retrieve a document from ConnectWise
     *
     * @throws \LabtechSoftware\ConnectwisePsaSdk\ApiException
     * @throws \InvalidArgumentException
     * @param string|int $documentId numeric, the id of the document to get
     * @return array Representation of a document
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
