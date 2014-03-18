<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use LabtechSoftware\ConnectwisePsaSdk\Support\ApiException,
    LabtechSoftware\ConnectwisePsaSdk\Support\ConnectWiseBase;

/**
 * ConnectWise Reporting API
 *
 * @package ConnectwisePsaSdk
 * @see LabtechSoftware\ConnectwisePsaSdk\Support\ConnectWiseBase
 */
class Reporting extends ConnectWiseBase
{
    /**
     * Gets the list of fields for a particular report
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param string $reportName
     * @return array
     */
    public function getReportFields($reportName = '')
    {
        if (is_string($reportName) === false) {
            throw new ApiException('Report name must be a string.');
        }

        $params = array('reportName' => $reportName);

        return parent::getConnection()->makeRequest('GetReportFields', $params);
    }

    /**
     * Gets the list of available reports
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param boolean $includeFields
     * @return array
     */
    public function getReports($includeFields = true)
    {
        // Check for boolean param
        if (is_bool($includeFields) === false) {
            throw new ApiException('Include fields parameter must be boolean.');
        }

        $params = array('includeFields' => $includeFields);

        return parent::getConnection()->makeRequest('GetReports', $params);
    }

    /**
     * Runs a particular report with a given set of conditions. 
     * Returns the # of records that would be returned.
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param string $reportName
     * @param string $conditions
     * @return array
     */
    public function runReportCount($reportName, $conditions = '')
    {
        if (is_string($reportName) === false) {
            throw new ApiException('Report name must be a string.');
        }

        if (is_string($conditions) === false) {
            throw new ApiException('Conditions must be a string.');
        }

        $params = array(
            'reportName' => $reportName,
            'conditions' => $conditions
        );

        return parent::getConnection()->makeRequest('RunReportCount', $params);
    }
    
    /**
     * Runs a particular report with a given set of conditions
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param string $reportName
     * @param int $limit
     * @param int $skip
     * @param string $conditions
     * @param string $orderBy
     * @return array
     */
    public function runReportQuery(
        $reportName,
        $limit = 100,
        $skip = 0,
        $conditions = '',
        $orderBy = ''
    )
    {
        if (is_string($reportName) === false) {
            throw new ApiException('Report name must be a string.');
        }

        if (is_numeric($limit) === false) {
            throw new ApiException('Limit value must be numeric.');
        }

        if (is_numeric($skip) === false) {
            throw new ApiException('Skip value must be numeric.');
        }

        if (is_string($conditions) === false) {
            throw new ApiException('Conditions value must be a string.');
        }

        if (is_string($orderBy) === false) {
            throw new ApiException('Order by value must be a string.');
        }

        $params = array(
            'reportName' => $reportName,
            'conditions' => $conditions,
            'orderBy'    => $orderBy,
            'skip'       => $skip
        );

        // Only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        return parent::getConnection()->makeRequest('RunReportQuery', $params);
    }

    /**
     * Runs a particular report with a given set of conditions
     *
     * @throws ApiException
     * @param string $reportName
     * @param int $limit
     * @param int $skip
     * @param string $conditions
     * @param string $orderBy
     * @param array $fieldFilters
     * @return array
     */
    public function runReportQueryWithFilters(
        $reportName,
        $limit = 100,
        $skip = 0,
        $conditions = '',
        $orderBy = '',
        $fieldFilters = array()
    )
    {
        if (is_string($reportName) === false) {
            throw new ApiException('Report name must be a string.');
        }

        if (is_numeric($limit) === false) {
            throw new ApiException('Limit value must be numeric.');
        }

        if (is_numeric($skip) === false) {
            throw new ApiException('Skip value must be numeric.');
        }

        if (is_string($conditions) === false) {
            throw new ApiException('Conditions value must be a string.');
        }

        if (is_string($orderBy) === false) {
            throw new ApiException('Order by value must be a string.');
        }

        if (is_array($fieldFilters) === false) {
            throw new ApiException('FieldFilters value must be an array.');
        }

        $params = array(
            'reportName' => $reportName,
            'conditions' => $conditions,
            'orderBy' => $orderBy,
            'skip' => $skip,
            'fieldFilters' => $fieldFilters
        );

        // only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        return parent::getConnection()->makeRequest(
            'RunReportQueryWithFilters',
            $params
        );
    }
}