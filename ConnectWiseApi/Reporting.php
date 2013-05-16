<?php namespace ConnectWiseApi;

use SoapFault,
    ConnectWiseApi\ApiResource,
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
        try
        {
            $getReports = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetPortalReports(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($getReports, 'GetPortalReportsResult');

            return ApiResult::getAll();    
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
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

        try
        {
            $reportFields = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetReportFields(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($reportFields, 'GetReportFieldsResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
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

        try
        {
            $getResults = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetReports(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($getResults->GetReportsResult, 'Report');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
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

        try
        {
            $runReport = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->RunPortalReport(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($runReport->RunPortalReportResult, 'ResultRow');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
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
        if (is_string($reportName) === false)
        {
            throw new ApiException('Report name must be a string.');
        }

        if (is_string($conditions) === false)
        {
            throw new ApiException('Conditions must be a string.');
        }

        ApiRequestParams::set('reportName', $reportName);

        try
        {
            $result = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->RunReportCount(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($result, 'RunReportCountResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
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

        if (is_string($reportName) === false)
        {
            throw new ApiException('Report name must be a string.');
        }

        if (is_string($conditions) === false)
        {
            throw new ApiException('Conditions value must be a string.');
        }

        if (is_string($orderBy) === false)
        {
            throw new ApiException('Order by value must be a string.');
        }
        
        ApiRequestParams::set('reportName', $reportName);
        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('orderBy', $orderBy);
        ApiRequestParams::set('limit', $limit);
        ApiRequestParams::set('skip', $skip);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->RunReportQuery(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->RunReportQueryResult, 'ResultRow');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
}