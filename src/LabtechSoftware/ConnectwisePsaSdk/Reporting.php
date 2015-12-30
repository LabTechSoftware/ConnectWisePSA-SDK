<?php namespace LabtechSoftware\ConnectwisePsaSdk;

/**
 * ConnectWise Reporting API
 *
 * @package ConnectwisePsaSdk
 */
class Reporting
{
    private $client;

    public function __construct(ConnectWiseApi $client)
    {
        $this->client = $client;
    }

    /**
     * Gets the list of fields for a particular report
     *
     * @throws ApiException
     * @param string $reportName
     * @return array
     */
    public function getReportFields($reportName = '')
    {
        if (is_string($reportName) === false) {
            throw new ApiException('Report name must be a string.');
        }

        $params = array(
            'reportName' => $reportName
        );

        return $this->client->makeRequest('GetReportFields', $params);
    }

    /**
     * Gets the list of available reports
     *
     * @throws ApiException
     * @param boolean $includeFields
     * @return array
     */
    public function getReports($includeFields = true)
    {
        // Check for boolean param
        if (is_bool($includeFields) === false) {
            throw new ApiException('Include fields parameter must be boolean.');
        }

        $params = array(
            'includeFields' => $includeFields
        );

        return $this->client->makeRequest('GetReports', $params);
    }

    /**
     * Runs a particular report with a given set of conditions. Returns the # of records that would be returned.
     *
     * @throws ApiException
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

        return $this->client->makeRequest('RunReportCount', $params);
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
     * @return array
     */
    public function runReportQuery($reportName, $limit = 100, $skip = 0, $conditions = '', $orderBy = '')
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
            'orderBy' => $orderBy,
            'skip' => $skip
        );

        // only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        $result = $this->getData(
            $this->client->makeRequest('RunReportQuery', $params),
            'RunReportQueryResult'
        );

        return $this->prepareReport($result);
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
    public function runReportQueryWithFilters($reportName, $limit = 100, $skip = 0, $conditions = '', $orderBy = '', $fieldFilters = array())
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

        // make the request and get data from the returned object
        $result = $this->getData(
            $this->client->makeRequest('RunReportQueryWithFilters', $params),
            'RunReportQueryWithFiltersResult'
        );

        // send pulled data to prepare report, for a more sane data structure
        return $this->prepareReport($result);
    }

    /*
     * Helper method, manipulates data structure given from ConnectWise, into a structure that is easier to work with
     */
    private function prepareReport(array $report)
    {
        $items = array();
        foreach ($report as $item) {
            $tmpItems = new \stdClass();
            foreach ($item->Value as $v) {
                $tmpItems->{$v->Name} = $v->_;
            }
            $items[] = $tmpItems;
        }

        return $items;
    }

    /**
     * Helper method, pulls the data structure giving from ConnectWise
     *
     * @param object $report The report as giving back from ConnectWise
     * @param string $reportName The name of the method used on Reporting API
     * @return array|bool
     */
    private function getData($report, $reportName)
    {
        if (isset($report->{$reportName}->ResultRow)) {
            $report = $report->{$reportName}->ResultRow;
        } elseif (isset($report->{$reportName})) {
            $report = [];
        } else {
            $report = false;
        }

        return $report;
    }
}
