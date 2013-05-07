<?php namespace Api\ConnectWise;

use Api\ApiResource,
    Api\ApiRequestParams,
    Api\ApiResult,
    Api\ApiException;

class Configuration
{
    protected static $currentApi = 'ConfigurationAPI';

    /**
     * @todo test
     */
    public static function addConfiguration(array $config)
    {
        /*
            $requiredKeys = array('configuration' => array('Id', 'ConfigurationTypeId', 'ConfigurationType', 'Status', 'ConfigurationName',
                'ContactName', 'CompanyName', 'CompanyId', 'ContactId', 'OwnerLevelId', 'BillingUnitId', 
                'Manufacturer', 'ManufacturerId', 'SerialNumber', 'ModelNumber', 'TagNumber', 'PurchaseDate',
                'InstallationDate', 'InstalledBy', 'WarrantyExpiration', 'LastUpdate', 'UpdatedBy', 'AddressId',
                'AddressLine1', 'AddressLine2', 'City', 'State', 'ZipCode', 'VendorNotes', 'Notes', 'MacAddress',
                'LastLoginName', 'BillFlag', 'BackupSuccesses', 'BackupIncomplete', 'BackupFailed', 'BackupRestores',
                'LastBackupDate', 'BackupServerName', 'BackupBillableSpaceGb', 'BackupProtectedDeviceList', 'BackupYear',
                'BackupMonth', 'IPAddress', 'DefaultGateway', 'OSType', 'OSInfo', 'CPUSpeed', 'RAM', 'LocalHardDrives', 
                'IsActive', 'ConfigurationQuestions'
            ));
        */

        ApiRequestParams::set('configuration', $config);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddConfiguration(ApiRequestParams::getAll());

        ApiResult::addResult($results->AddConfigurationResult);

        return ApiResult::getAll();
    }

    /**
     * @todo test
     */
    public static function addConfigurationType(array $configType)
    {
        ApiRequestParams::set('configurationType', $configType);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddConfigurationType(ApiRequestParams::getAll());

        ApiResult::addResult($results->AddConfigurationTypeResult);

        return ApiResult::getAll();
    }

    /**
     * @todo test
     */
    public static function addOrUpdateConfiguration(array $config)
    {
        ApiRequestParams::set('configuration', $config);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddOrUpdateConfiguration(ApiRequestParams::getAll());

        ApiResult::addResult($results->AddOrUpdateConfigurationResult);

        return ApiResult::getAll();
    }

    /**
     * @todo test
     */
    public static function addOrUpdateConfigurationType(array $configType)
    {
        ApiRequestParams::set('configurationType', $configType);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->AddOrUpdateConfigurationType(ApiRequestParams::getAll());

        ApiResult::addResult($results->AddOrUpdateConfigurationTypeResult);

        return ApiResult::getAll();
    }

    public static function findConfigurationTypes($limit = 0, $skip = 0, $conditions = null, $orderBy = null)
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
            ->FindConfigurationTypes(ApiRequestParams::getAll());

        if (method_exists($findResults->FindConfigurationTypesResult, 'ConfigurationTypeFindResult') === true)
        {
            ApiResult::addResult($findResults->FindConfigurationTypesResult->ConfigurationTypeFindResult);
        }
        elseif (property_exists($findResults->FindConfigurationTypesResult, 'ConfigurationTypeFindResult') === true)
        {
            ApiResult::addResult($findResults->FindConfigurationTypesResult->ConfigurationTypeFindResult);
        }
        else
        {
            ApiResult::addResult($findResults->FindConfigurationTypesResult);
        }

        return ApiResult::getAll();
    }

    public static function findConfigurations($limit = 0, $skip = 0, $conditions = null, $orderBy = null)
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

        if (method_exists($findResults->FindConfigurationsResult, 'ConfigurationFindResult') === true)
        {
            ApiResult::addResult($findResults->FindConfigurationsResult->ConfigurationFindResult);
        }
        elseif (property_exists($findResults->FindConfigurationsResult, 'ConfigurationFindResult') === true)
        {
            ApiResult::addResult($findResults->FindConfigurationsResult->ConfigurationFindResult);
        }
        else
        {
            ApiResult::addResult($findResults->FindConfigurationsResult);
        }

        return ApiResult::getAll();
    }

    public static function findConfigurationsCount($isOpen = false, $conditions = '')
    {
        if (is_bool($isOpen) === false)
        {
            throw new ApiException('Is Open param must be boolean.');
        }

        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('isOpen', $isOpen);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->FindConfigurationsCount(ApiRequestParams::getAll());

        ApiResult::addResult($results->FindConfigurationsCountResult);

        return ApiResult::getAll();
    }

    public static function getConfiguration($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('Configuration ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetConfiguration(ApiRequestParams::getAll());

        ApiResult::addResult($results->GetConfigurationResult);

        return ApiResult::getAll();
    }

    public static function getConfigurationType($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('ConfigurationType ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->GetConfigurationType(ApiRequestParams::getAll());

        ApiResult::addResult($results->GetConfigurationTypeResult);

        return ApiResult::getAll();
    }

    public static function loadConfiguration($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('Configuration ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->LoadConfiguration(ApiRequestParams::getAll());

        ApiResult::addResult($results->LoadConfigurationResult);

        return ApiResult::getAll();
    }

    public static function loadConfigurationType($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('ConfigurationType ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->LoadConfigurationType(ApiRequestParams::getAll());

        ApiResult::addResult($results->LoadConfigurationTypeResult);

        return ApiResult::getAll();
    }

    /**
     * @todo test
     */
    public static function updateConfiguration(array $configuration)
    {
        ApiRequestParams::set('configuration', $configuration);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->UpdateConfiguration(ApiRequestParams::getAll());

        ApiResult::addResult($results->UpdateConfigurationResult);

        return ApiResult::getAll();
    }

    /**
     * @todo test
     */
    public static function updateConfigurationType(array $configurationType)
    {
        ApiRequestParams::set('configurationType', $configurationType);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->UpdateConfigurationType(ApiRequestParams::getAll());

        ApiResult::addResult($results->UpdateConfigurationTypeResult);

        return ApiResult::getAll();
    }

    /**
     * @todo test
     */
    public static function deleteConfiguration($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('Configuration ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->DeleteConfiguration(ApiRequestParams::getAll());

        if (method_exists($results, 'DeleteConfigurationResult') === true)
        {
            ApiResult::addResult($results->DeleteConfigurationResult);    
        }
        else
        {
            ApiResult::addResult($results);
        }

        return ApiResult::getAll();
    }

    /**
     * @todo test
     */
    public static function deleteConfigurationType($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('ConfigurationType ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->DeleteConfigurationType(ApiRequestParams::getAll());

        if (method_exists($results, 'DeleteConfigurationTypeResult') === true)
        {
            ApiResult::addResult($results->DeleteConfigurationTypeResult);
        }
        else
        {
            ApiResult::addResult($results);
        }

        return ApiResult::getAll();
    }

    /**
     * @todo test
     */
    public static function deleteConfigurationTypeQuestion($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('ConfigurationTypeQuestion ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->DeleteConfigurationTypeQuestion(ApiRequestParams::getAll());

        if (method_exists($results, 'DeleteConfigurationTypeQuestionResult') === true)
        {
            ApiResult::addResult($results->DeleteConfigurationTypeQuestionResult);
        }
        else
        {
            ApiResult::addResult($results);
        }

        return ApiResult::getAll();
    }

    /**
     * @todo test
     */
    public static function deletePossibleResponse($id)
    {
        if (is_int($id) === false)
        {
            throw new ApiException('PossibleResponse ID must be an integer.');
        }

        ApiRequestParams::set('id', $id);

        $results = ApiResource::run('api_connection', 'start', static::$currentApi)
            ->DeletePossibleResponse(ApiRequestParams::getAll());

        if (method_exists($results, 'DeletePossibleResponseResult') === true)
        {
            ApiResult::addResult($results->DeletePossibleResponseResult);
        }
        else
        {
            ApiResult::addResult($results);
        }

        return ApiResult::getAll();
    }
}