<?php namespace LabtechSoftware\ConnectwisePsaSdk;

require 'boot.php';

use SoapFault,
    LabtechSoftware\ConnectwisePsaSdk\ApiResource,
    LabtechSoftware\ConnectwisePsaSdk\ApiRequestParams,
    LabtechSoftware\ConnectwisePsaSdk\ApiResult,
    LabtechSoftware\ConnectwisePsaSdk\ApiException;

/**
 * ConnectWise Company API
 *
 * @package ConnectwisePsaSdk
 */
class Company
{
    /**
     * The API name for the SOAP connection
     *
     * @var string
     */
    protected static $currentApi = 'CompanyAPI';

    /**
     * Add a new company to CW
     *
     * @throws ApiException
     * @param array $company
     * @return array
     */
    public static function addCompany(array $company)
    {
        // Check for empty data array
        if (count($company) <= 0)
        {
            throw new ApiException('No data found in new company array.');
        }

        ApiRequestParams::set('company', $company);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddCompany(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddCompanyResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Add or update a company to/in CW
     *
     * @throws ApiException
     * @param array $company
     * @return array
     */
    public static function addOrUpdateCompany(array $company)
    {
        // Check for empty data array
        if (count($company) <= 0)
        {
            throw new ApiException('No data found in company array.');
        }

        ApiRequestParams::set('company', $company);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddOrUpdateCompany(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddOrUpdateCompanyResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Get a company by ID from CW
     *
     * @throws ApiException
     * @param numeric $companyId
     * @return array
     */
    public static function getCompany($companyId)
    {
        // Make sure company ID is numeric
        if (is_numeric($companyId) === false)
        {
            throw new ApiException('Invalid company ID value.');
        }

        ApiRequestParams::set('id', $companyId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetCompany(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'GetCompanyResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
}