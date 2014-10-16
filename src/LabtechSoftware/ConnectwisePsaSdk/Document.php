<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use Exception;


class Document
{
    private $client;

    public function __construct(ConnectWiseApi $client)
    {
        $this->client = $client;
    }

    public function addDocuments($objectId, $documentTableReference, $documentInfo)
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

        return $this->client->makeRequest('AddDocuments', $params);
    }

    public function getDocument($documentId)
    {
        if (!is_numeric($documentId)) {
            throw new ApiException('DocumentId value must be numeric.');
        }

        if ($documentId <= 0) {
            throw new ApiException('DocumentId value must be greater than zero.');
        }

        $params = [
            'documentId' => $documentId
        ];

        return $this->client->makeRequest('GetDocument', $params);
    }
}
