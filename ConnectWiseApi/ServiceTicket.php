<?php namespace ConnectWiseApi;

use ConnectWiseApi\ApiResource,
    ConnectWiseApi\ApiRequestParams,
    ConnectWiseApi\ApiResult,
    ConnectWiseApi\ApiException;

class ServiceTicket
{
    protected static $currentApi = 'ServiceTicketApi';
    
    public static function find($limit, $skip, $conditions = null, $orderBy = null)
    {
        if (is_int($limit) === false)
        {
            throw new ApiException('Limit value must be an integer.');
        }

        if (is_int($skip) === false)
        {
            throw new ApiException('Skip value must be an integer.');
        }

        ApiRequestParams::set('limit', $limit);
        ApiRequestParams::set('skip', $skip);
        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('orderBy', $orderBy);

        $findResults = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->FindServiceTickets(ApiRequestParams::getAll());

        ApiResult::addResult($findResults->FindServiceTicketsResult->Ticket);

        return ApiResult::getAll();
    }
    
    public static function addViaCompanyId($companyId, $serviceTicket)
    {
        ApiRequestParams::set('companyId', $companyId);
        ApiRequestParams::set('serviceTicket', $serviceTicket);

        $addResults = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddServiceTicketViaCompanyId(ApiRequestParams::getAll());

        ApiResult::addResult($addResults->AddServiceTicketViaCompanyIdResult->Ticket);

        return ApiResult::getAll();
    }
}