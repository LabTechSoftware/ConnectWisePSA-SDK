<?php namespace LabtechSoftware\ConnectwisePsaSdk\Rest;

class ContactApi
{
    private $client;
    private $api = 'company/contacts';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function authenticate(array $credentials)
    {
        $method = 'POST';
        $uri = $this->api . '/validatePortalCredentials';
        $options = ['json' => $credentials];

        return $this->client->makeRequest($method, $uri, $options);
    }

    public function update($id, array $operations)
    {
        $method = 'PATCH';
        $uri = $this->api . '/' . $id;
        $options = ['json' => $operations];

        return $this->client->makeRequest($method, $uri, $options);
    }
}