<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use LabtechSoftware\ConnectwisePsaSdk\Support\ApiException,
    LabtechSoftware\ConnectwisePsaSdk\Support\ConnectWiseBase;

/**
 * ConnectWise Company API
 *
 * @package ConnectwisePsaSdk
 * @see LabtechSoftware\ConnectwisePsaSdk\Support\ConnectWiseBase
 */
class Company extends ConnectWiseBase
{
    /**
     * Add or update a company to/in CW
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param array $company
     * @return array
     */
    public function addOrUpdateCompany(array $company)
    {
        // Check for empty data array
        if (count($company) <= 0) {
            throw new ApiException('No data found in company array.');
        }

        $params = array('company' => $company);

        return parent::getConnection()->makeRequest(
            'AddOrUpdateCompany',
            $params
        );
    }

    /**
     * Get a company by ID from CW
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $companyId
     * @return array
     */
    public function getCompany($companyId)
    {
        // Make sure company ID is numeric and not zero
        if (is_numeric($companyId) === false || $companyId <= 0) {
            throw new ApiException('Invalid company ID value.');
        }

        $params = array('id' => $companyId);

        return parent::getConnection()->makeRequest('GetCompany', $params);
    }

    /**
     * Delete a company by ID fom CW
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $companyId
     * @return array
     */
    public function deleteCompany($companyId)
    {
        if (is_numeric($companyId) === false) {
            throw new ApiException('Invalid company ID value.');
        }

        $params = array('id' => $companyId);

        return parent::getConnection()->makeRequest('DeleteCompany', $params);
    }

    /**
     * Finds contact information by a set of conditions
     *
     * @throws LabtechSoftware\ConnectwisePsaSdk\Support\ApiException
     * @param int $limit
     * @param int $skip
     * @param string $orderBy
     * @param string $conditions
     * @return array
     */
    public function findCompanies(
        $limit = 0,
        $skip = 0,
        $orderBy = '',
        $conditions = ''
    )
    {
        if (is_numeric($limit) === false) {
            throw new ApiException('Limit value must be numeric.');
        }

        if (is_numeric($skip) === false) {
            throw new ApiException('Skip value must be numeric.');
        }

        if (is_string($orderBy) === false) {
            throw new ApiException('Order by must be a string.');
        }

        if (is_string($conditions) === false) {
            throw new ApiException('Conditions must be a string.');
        }

        $params = array(
            'skip'       => $skip,
            'conditions' => $conditions,
            'orderBy'    => $orderBy
        );

        // Only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        return parent::getConnection()->makeRequest('FindCompanies', $params);
    }
}