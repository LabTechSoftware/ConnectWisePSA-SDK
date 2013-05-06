<?php namespace Api\ConnectWise;

use Api\ApiResource,
    Api\ApiRequestParams,
    Api\ApiResult,
    Api\ApiException;

class Configuration
{
    protected static $currentApi = 'ConfigurationAPI';

    public static function findTypes($limit, $skip, $conditions = null, $orderBy = null)
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
            ->FindConfigurations(ApiRequestParams::getAll());

        ApiResult::addResult($findResults->FindConfigurationsResult->ConfigurationFindResult);

        return ApiResult::getAll();
    }

    public static function addConfiruration()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function addConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function addOrUpdateConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function addOrUpdateConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function deleteConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function deleteConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function deleteConfigurationTypeQuestion()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function deletePossibleResponse()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function findConfigurationsCount()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function getConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function getConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function loadConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function loadConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function updateConfiguration()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }

    public static function updateConfigurationType()
    {
        // NOT IMPLIMENTED YET
        throw new ApiException(__CLASS__."::".__FUNCTION__." is not implimented yet.");
    }
}