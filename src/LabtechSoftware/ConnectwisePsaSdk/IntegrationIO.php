<?php namespace LabtechSoftware\ConnectwisePsaSdk;

class IntegrationIO
{
    private $client;

    public function __construct(ConnectWiseApi $client)
    {
        $this->client = $client;
    }

    /**
     * Gets a list of ticket statuses available for the portal, per ticket
     *
     * @param $serviceTicketRecId
     * @return mixed
     * @throws ApiException
     */
    public function getPortalTicketStatuses($serviceTicketRecId)
    {
        if (!is_numeric($serviceTicketRecId)) {
            throw new ApiException('argument 1 must be numeric');
        }

        $creds = $this->client->getConfigLoader()->getSoapCredentials();
        $companyName = $creds['CompanyId'];
        $login = $creds['IntegratorLoginId'];
        $pass = $creds['IntegratorPassword'];

        $params = [
            'actionString' => '<?xml version="1.0" encoding="utf-8"?>
							<GetTicketStatusesAction xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
								<CompanyName>'. $companyName . '</CompanyName>
								<IntegrationLoginId>'. $login . '</IntegrationLoginId>
								<IntegrationPassword>'. $pass .'</IntegrationPassword>
								<SrServiceRecID>'. $serviceTicketRecId . '</SrServiceRecID>
								<OnlyShowPortalStatuses>true</OnlyShowPortalStatuses>
							</GetTicketStatusesAction>'
        ];

        $result = $this->client->makeRequest('ProcessClientAction', $params);
        $result->ProcessClientActionResult = simplexml_load_string($result->ProcessClientActionResult);
        return $result;
    }
}
