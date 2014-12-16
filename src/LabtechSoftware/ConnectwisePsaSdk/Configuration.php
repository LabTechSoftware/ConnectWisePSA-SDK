<?php namespace LabtechSoftware\ConnectwisePsaSdk;

/**
 * ConnectWise Configuration API
 *
 * @package ConnectwisePsaSdk
 */
class Configuration
{
    private $client;

    public function __construct(ConnectWiseApi $client)
    {
        $this->client = $client;
    }

    /**
     * Adds or updates a configuration
     *
     * @throws ApiException
     * @param array $config
     * @return array
     */
    public function addOrUpdateConfiguration(array $config)
    {
        $params = array(
            'configuration' => $config
        );

        return $this->client->makeRequest('AddOrUpdateConfiguration', $params);
    }

    /**
     * Adds a configuration
     *
     * @throws ApiException
     * @param array $config
     * @return array
     */
    public function addConfiguration(array $config)
    {
        $params = array(
            'configuration' => $config
        );

        return $this->client->makeRequest('AddConfiguration', $params);
    }

    /**
     * Updates a configuration
     *
     * @throws ApiException
     * @param array $config
     * @return array
     */
    public function updateConfiguration(array $config)
    {
        $params = array(
            'configuration' => $config
        );

        return $this->client->makeRequest('UpdateConfiguration', $params);
    }

    /**
     * Adds or updates a configuration type
     *
     * @throws ApiException
     * @param array $configType
     * @return array
     */
    public function addOrUpdateConfigurationType(array $configType)
    {
        $params = array(
            'configurationType' => $configType
        );

        return $this->client->makeRequest('AddOrUpdateConfigurationType', $params);
    }

    /**
     * Finds configuration types
     *
     * @throws ApiException
     * @param int $limit
     * @param int $skip
     * @param mixed string $conditions
     * @param string $orderBy
     * @return array
     */
    public function findConfigurationTypes($limit = 0, $skip = 0, $conditions = '', $orderBy = '')
    {
        if (is_numeric($limit) === false) {
            throw new ApiException('Limit value must be numeric.');
        }

        if (is_numeric($skip) === false) {
            throw new ApiException('Skip value must be numeric.');
        }

        if (is_string($conditions) === false) {
            throw new ApiException('Conditions must be a string.');
        }

        if (is_string($orderBy) === false) {
            throw new ApiException('Order by must be a string.');
        }

        $params = array(
            'skip' => $skip,
            'conditions' => $conditions,
            'orderBy' => $orderBy
        );

        // only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        return $this->client->makeRequest('FindConfigurationTypes', $params);
    }

    /**
     * Find configurations
     *
     * @throws ApiException
     * @param int $limit
     * @param int $skip
     * @param mixed string $conditions
     * @param string $orderBy
     * @return array
     */
    public function findConfigurations($limit = 0, $skip = 0, $conditions = '', $orderBy = '')
    {
        if (is_numeric($limit) === false) {
            throw new ApiException('Limit value must be numeric.');
        }

        if (is_numeric($skip) === false) {
            throw new ApiException('Skip value must be numeric.');
        }

        if (is_string($conditions) === false) {
            throw new ApiException('Conditions must be a string.');
        }

        if (is_string($orderBy) === false) {
            throw new ApiException('Order by must be a string.');
        }

        $params = array(
            'skip' => $skip,
            'conditions' => $conditions,
            'orderBy' => $orderBy
        );

        // only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        return $this->client->makeRequest('FindConfigurations', $params);
    }

    /**
     * Gets a count of available configurations. Optionally filters by the supplied conditions.
     *
     * @throws ApiException
     * @param boolean $isOpen
     * @param string $conditions
     * @return array
     */
    public function findConfigurationsCount($isOpen = false, $conditions = '')
    {
        if (is_bool($isOpen) === false) {
            throw new ApiException('Is Open param must be boolean.');
        }

        if (is_string($conditions) === false) {
            throw new ApiException('Conditions must be a string.');
        }

        $params = array(
            'conditions' => $conditions,
            'isOpen' => $isOpen
        );

        return $this->client->makeRequest('FindConfigurationsCount', $params);
    }

    /**
     * Gets a configuration by database record id. 
     * If no configuration exists with the given id, an empty array is returned
     *
     * @throws ApiException
     * @param int $id
     * @return array
     */
    public function getConfiguration($id)
    {
        if (is_numeric($id) === false) {
            throw new ApiException('Configuration ID must be numeric.');
        }

        $params = array(
            'id' => $id
        );

        return $this->client->makeRequest('GetConfiguration', $params);
    }

    /**
     * Gets a configuration type by database record id. 
     * If no configuration exists with the given id, an empty array is returned
     *
     * @throws ApiException
     * @param int $id
     * @return array
     */
    public function getConfigurationType($id)
    {
        if (is_numeric($id) === false) {
            throw new ApiException('ConfigurationType ID must be numeric.');
        }

        $params = array(
            'id' => $id
        );

        return $this->client->makeRequest('GetConfigurationType', $params);
    }

    /**
     * Delete an existing configuration
     *
     * @throws ApiException
     * @param int $id
     * @return array
     */
    public function deleteConfiguration($id)
    {
        if (is_numeric($id) === false) {
            throw new ApiException('Configuration ID must be numeric.');
        }

        $params = array(
            'id' => $id
        );

        return $this->client->makeRequest('DeleteConfiguration', $params);
    }

    /**
     * Deletes an existing configuration type
     *
     * @throws ApiException
     * @param int $id
     * @return array
     */
    public function deleteConfigurationType($id)
    {
        if (is_numeric($id) === false) {
            throw new ApiException('ConfigurationType ID must be numeric.');
        }

        $params = array(
            'id' => $id
        );

        return $this->client->makeRequest('DeleteConfigurationType', $params);
    }

    /**
     * Deletes a question from an existing configuration type
     *
     * @throws ApiException
     * @param int $id
     * @return array
     */
    public function deleteConfigurationTypeQuestion($id)
    {
        if (is_numeric($id) === false) {
            throw new ApiException('ConfigurationTypeQuestion ID must be numeric.');
        }

        $params = array(
            'id' => $id
        );

        return $this->client->makeRequest('DeleteConfigurationTypeQuestion', $params);
    }

    /**
     * Deletes a possible response from an existing configuration type question
     *
     * @throws ApiException
     * @param int $id
     * @return array
     */
    public function deletePossibleResponse($id)
    {
        if (is_numeric($id) === false) {
            throw new ApiException('PossibleResponse ID must be numeric.');
        }

        $params = array(
            'id' => $id
        );

        return $this->client->makeRequest('DeletePossibleResponse', $params);
    }
}
