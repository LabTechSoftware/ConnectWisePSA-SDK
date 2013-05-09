<?php namespace ConnectWiseApi;

use ConnectWiseApiApi\Resource,
    ConnectWiseApiApi\RequestParams,
    ConnectWiseApiApi\Result,
    ConnectWiseApiApi\Exception;

class Reporting
{
    protected static $currentApi = 'ReportingAPI';
    
    /**
     * @todo Test on a PSA account with sufficient permissions (insufficient perms throws an exception)
     */
    public static function getPortalReports()
    {
        $getReports = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetPortalReports(ApiRequestParams::getAll());

        ApiResult::addResult($getReports->GetPortalReportsResult);

        return ApiResult::getAll();
    }
    
    public static function getReportFields($reportName)
    {
        ApiRequestParams::set('reportName', $reportName);

        $reportFields = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetReportFields(ApiRequestParams::getAll());

        ApiResult::addResult($reportFields->GetReportFieldsResult);

        return ApiResult::getAll();
    }
    
    public static function getReports($includeFields = true)
    {
        // Check for boolean param
        if (is_bool($includeFields) === false)
        {
            throw new ApiException('getReports parameter must be boolean.');
        }

        ApiRequestParams::set('includeFields', $includeFields);

        $getResults = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetReports(ApiRequestParams::getAll());

        ApiResult::addResult($getResults->GetReportsResult->Report);

        return ApiResult::getAll();
    }
    
    /**
     * @todo Unable to test, need a valid portal report name to finish
     */
    public static function runPortalReport($reportName = '', $conditions = '', $orderBy = '', $limit = 100, $skip = 0)
    {
        if (is_int($limit) === false)
        {
            throw new ApiException('Limit value must be an integer.');
        }

        if (is_int($skip) === false)
        {
            throw new ApiException('Skip value must be an integer.');
        }

        ApiRequestParams::set('reportName', $reportName);
        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('orderBy', $orderBy);
        ApiRequestParams::set('limit', $limit);
        ApiRequestParams::set('skip', $skip);

        $runReport = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->RunPortalReport(ApiRequestParams::getAll());

        ApiResult::addResult($runReport->RunPortalReportResult);

        return ApiResult::getAll();
    }

    public static function runReportCount($reportName, $conditions = '')
    {
        ApiRequestParams::set('reportName', $reportName);

        $reportCountResult = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->RunReportCount(ApiRequestParams::getAll());

        ApiResult::addResult($reportCountResult->RunReportCountResult);

        return ApiResult::getAll();
    }
    
    public static function runReportQuery($reportName = null, $conditions = '', $orderBy = '', $limit = 100, $skip = 0)
    {
        // Report name? :O
        if (is_null($reportName) === true)
        {
            throw new ApiException('No report name given.');
        }

        if (is_int($limit) === false)
        {
            throw new ApiException('Limit value must be an integer.');
        }

        if (is_int($skip) === false)
        {
            throw new ApiException('Skip value must be an integer.');
        }
        
        ApiRequestParams::set('reportName', $reportName);
        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('orderBy', $orderBy);
        ApiRequestParams::set('limit', $limit);
        ApiRequestParams::set('skip', $skip);

        $runResults = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->RunReportQuery(ApiRequestParams::getAll());

        ApiResult::addResult($runResults->RunReportQueryResult->ResultRow);

        return ApiResult::getAll();
    }
}