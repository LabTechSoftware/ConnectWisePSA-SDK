<?php namespace ConnectWiseApi;

use ConnectWiseApi\ApiResource,
    ConnectWiseApi\ApiRequestParams,
    ConnectWiseApi\ApiResult,
    ConnectWiseApi\ApiException;

class Reporting
{
    /**
     * The API name for the SOAP connection
     *
     * @var string
     */
    protected static $currentApi = 'ReportingAPI';
    
    /**
     * Gets the list of reports accessible via the customer portal
     * @todo Test on a PSA account with sufficient permissions (insufficient perms throws an exception)
     *
     * @return array
     */
    public static function getPortalReports()
    {
        $getReports = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetPortalReports(ApiRequestParams::getAll());

        ApiResult::addResultFromObject($getReports, 'GetPortalReportsResult');

        return ApiResult::getAll();
    }

    /**
     * Gets the list of fields for a particular report
     *
     * @throws ApiException
     * @param string $reportName
     * @return array
     */
    public static function getReportFields($reportName = null)
    {
        if (is_null($reportName) === true)
        {
            throw new ApiException('Report name required for get report fields.');
        }

        ApiRequestParams::set('reportName', $reportName);

        $reportFields = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetReportFields(ApiRequestParams::getAll());

        ApiResult::addResultFromObject($reportFields, 'GetReportFieldsResult');

        return ApiResult::getAll();
    }

    /**
     * Gets the list of available reports
     *
     * @throws ApiException
     * @param boolean $includeFields
     * @return array
     */
    public static function getReports($includeFields = true)
    {
        // Check for boolean param
        if (is_bool($includeFields) === false)
        {
            throw new ApiException('Include fields parameter must be boolean.');
        }

        ApiRequestParams::set('includeFields', $includeFields);

        $getResults = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetReports(ApiRequestParams::getAll());

        ApiResult::addResultFromObject($getResults->GetReportsResult, 'Report');

        return ApiResult::getAll();
    }
    
    /**
     * Run a portal report with the given set of condiitons
     * @todo Unable to test, need a valid portal report name to finish
     *
     * @throws ApiException
     * @param integer $limit
     * @param integer $skip
     * @param string $reportName
     * @param string $conditions
     * @param string $orderBy
     * @return array
     */
    public static function runPortalReport($limit = 100, $skip = 0, $reportName = '', $conditions = '', $orderBy = '')
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

        ApiResult::addResultFromObject($runReport->RunPortalReportResult, 'ResultRow');

        return ApiResult::getAll();
    }

    /**
     * Runs a particular report with a given set of conditions. Returnss the # of records that would be returned.
     *
     * @param string $reportName
     * @param string $conditions
     * @return array
     */
    public static function runReportCount($reportName, $conditions = '')
    {
        ApiRequestParams::set('reportName', $reportName);

        $result = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->RunReportCount(ApiRequestParams::getAll());

        ApiResult::addResultFromObject($result, 'RunReportCountResult');

        return ApiResult::getAll();
    }
    
    /**
     * Runs a particular report with a given set of conditions
     *
     * @throws ApiException
     * @param string $reportName
     * @param integer $limit
     * @param integer $skip
     * @param string $conditions
     * @param string $orderBy
     * @return array
     */
    public static function runReportQuery($reportName, $limit = 100, $skip = 0, $conditions = '', $orderBy = '')
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

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->RunReportQuery(ApiRequestParams::getAll());

        ApiResult::addResultFromObject($results->RunReportQueryResult, 'ResultRow');

        return ApiResult::getAll();
    }
}