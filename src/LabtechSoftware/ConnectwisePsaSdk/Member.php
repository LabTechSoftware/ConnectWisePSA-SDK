<?php namespace LabtechSoftware\ConnectwisePsaSdk;

class Member
{
    private $client;

    public function __construct(ConnectWiseApi $client)
    {
        $this->client = $client;
    }


    public function isValidMemberIdAndPassword($memberId, $password)
    {
        if (!is_string($memberId)) {
            throw new ApiException('Member Id must be a string');
        }

        if (!is_string($password)) {
            throw new ApiException('Password must be a string');
        }

        $params = [
            'memberId' => $memberId,
            'password' => $password
        ];

        return $this->client->makeRequest('isValidMemberIdAndPassword', $params);
    }

    public function findMembers($conditions = '', $limit = 0, $orderBy = '', $skip = '')
    {
        $params = [
            'conditions' => $conditions,
            'orderBy' => $orderBy,
            'skip' => $skip,
        ];

        // only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        return $this->client->makeRequest('FindMembers', $params);
    }
}
