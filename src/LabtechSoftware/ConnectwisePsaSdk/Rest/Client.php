<?php namespace LabtechSoftware\ConnectwisePsaSdk\Rest;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{
    public function __construct($options)
    {
        parent::__construct($options);
    }

    public function makeRequest($method, $uri, array $options, $fullResponse = false)
    {
        $response = parent::request($method, $uri, $options);

        if ($fullResponse) {
            return $response;
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}