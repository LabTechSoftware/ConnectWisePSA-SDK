<?php namespace LabtechSoftware\ConnectwisePsaSdk\Rest;

class MarketingContactApi
{
    private $client;
    private $api = 'marketing/groups';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function add($groupId, $contactId, $message = '')
    {
        $method = 'POST';
        $uri = "{$this->api}/{$groupId}/contacts";
        $options = [
            'json' => [
                'id' => $contactId,
                'groupId' => $groupId,
                'note' => $message,
                'unsubscribeFlag' => false
            ]
        ];

        return $this->client->makeRequest($method, $uri, $options);
    }

    public function get($groupId, $contactId, $throwExceptions)
    {
        $method = 'GET';
        $uri = "{$this->api}/{$groupId}/contacts/{$contactId}";
        $options = ['http_errors' => $throwExceptions];

        return $this->client->makeRequest($method, $uri, $options, !$throwExceptions);
    }

    public function update($groupId, $contactId, array $operations)
    {
        $method = 'PATCH';
        $uri = "{$this->api}/{$groupId}/contacts/{$contactId}";
        $options = ['json' => $operations];

        return $this->client->makeRequest($method, $uri, $options);
    }
}