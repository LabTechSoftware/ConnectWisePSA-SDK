<?php namespace LabtechSoftware\ConnectwisePsaSdk;

require 'boot.php';

use SoapFault,
    LabtechSoftware\ConnectwisePsaSdk\ApiResource,
    LabtechSoftware\ConnectwisePsaSdk\ApiRequestParams,
    LabtechSoftware\ConnectwisePsaSdk\ApiResult,
    LabtechSoftware\ConnectwisePsaSdk\ApiException;

/**
 * ConnectWise Service Ticket API
 *
 * @package ConnectwisePsaSdk
 */
class ServiceTicket
{
    /**
     * The API name for the SOAP connection
     *
     * @var string
     */
    protected static $currentApi = 'ServiceTicketApi';
    
    /**
     * Adds or updates a service ticket for a company identified by the text-based company id. 
     * If the service ticket number is 0, the service ticket is added. 
     * If non-zero, the existing service ticket with that ticket number is updated.
     *
     * @param string $companyId
     * @param array $serviceTicket
     * @return array
     **/
    public static function addOrUpdateServiceTicketViaCompanyId($companyId, array $serviceTicket)
    {
        if (is_string($companyId) === false)
        {
            throw new ApiException('Company ID must be a string.');
        }

        ApiRequestParams::set('companyId', $companyId);
        ApiRequestParams::set('serviceTicket', $serviceTicket);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddOrUpdateServiceTicketViaCompanyId(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddOrUpdateServiceTicketViaCompanyIdResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Adds or updates a service ticket for a company identified by managed id. 
     * If the service ticket number is 0, the service ticket is added. 
     * If non-zero, the existing service ticket with that ticket number is updated.
     * @todo This is untested: need a valid managed id to test this method
     *
     * @param string $managedId
     * @param array $serviceTicket
     * @return array
     **/
    public static function addOrUpdateServiceTicketViaManagedId($managedId, array $serviceTicket)
    {
        if (is_string($managedId) === false)
        {
            throw new ApiException('Managed ID must be a string.');
        }

        ApiRequestParams::set('managedId', $managedId);
        ApiRequestParams::set('serviceTicket', $serviceTicket);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddOrUpdateServiceTicketViaManagedId(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddOrUpdateServiceTicketViaManagedIdResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Add or update a product on a ticket
     *
     * @param array $ticketProduct
     * @return array
     **/
    public static function addOrUpdateTicketProduct(array $ticketProduct)
    {
        ApiRequestParams::set('ticketProduct', $ticketProduct);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddOrUpdateTicketProduct(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddOrUpdateTicketProductResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Adds a new service ticket for a company identified by the *text-based* company id
     *
     * @throws ApiException
     * @param string $companyId
     * @param array $serviceTicket
     * @return array
     */
    public static function addServiceTicketViaCompanyId($companyId, array $serviceTicket)
    {
        if (is_string($companyId) === false)
        {
            throw new ApiException('Company ID must be a string.');
        }

        ApiRequestParams::set('companyId', $companyId);
        ApiRequestParams::set('serviceTicket', $serviceTicket);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddServiceTicketViaCompanyId(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->AddServiceTicketViaCompanyIdResult, 'Ticket');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Adds a new service ticket for a company identified by managed id
     * @todo This is untested: need a valid managed id to test this method
     *
     * @param string $managedId
     * @param array $serviceTicket
     * @return array
     **/
    public static function addServiceTicketViaManagedId($managedId, array $serviceTicket)
    {
        if (is_string($managedId) === false)
        {
            throw new ApiException('Managed ID must be a string.');
        }

        ApiRequestParams::set('managedId', $managedId);
        ApiRequestParams::set('serviceTicket', $serviceTicket);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddServiceTicketViaManagedId(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddServiceTicketViaManagedIdResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Add a product on a ticket
     *
     * @param array $ticketProduct
     * @return array
     **/
    public static function addTicketProduct(array $ticketProduct)
    {
        ApiRequestParams::set('ticketProduct', $ticketProduct);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->AddTicketProduct(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'AddTicketProductResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Finds service ticket information by a set of conditions
     *
     * @throws ApiException
     * @param integer $limit
     * @param integer $skip
     * @param string $conditions
     * @param string $orderBy
     * @return array
     */
    public static function findServiceTickets($limit = 100, $skip = 0, $conditions = '', $orderBy = '')
    {
        if (is_int($limit) === false) 
        {
            throw new ApiException('Limit value must be an integer.');
        }

        if (is_int($skip) === false)
        {
            throw new ApiException('Skip value must be an integer.');
        }

        if (is_string($conditions) === false)
        {
            throw new ApiException('Conditions value must be a string.');
        }

        if (is_string($orderBy) === false)
        {
            throw new ApiException('Order by value must be a string.');
        }

        ApiRequestParams::set('limit', $limit);
        ApiRequestParams::set('skip', $skip);
        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('orderBy', $orderBy);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->FindServiceTickets(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->FindServiceTicketsResult, 'Ticket');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Gets the list of statuses available to the specified ticket
     *
     * @throws ApiException
     * @param integer $ticketId
     * @return array
     **/
    public static function getServiceStatuses($ticketId)
    {
        if (is_int($ticketId) === false)
        {
            throw new ApiException('Ticket ID must be an integer.');
        }

        ApiRequestParams::set('ticketNumber', $ticketId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetServiceStatuses(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'GetServiceStatusesResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Gets a serice ticket by the ticket number (id)
     * If no service ticket exists with the given ticket number, an empty array is returned
     *
     * @throws ApiException
     * @param integer $ticketId
     * @return array
     **/
    public static function getServiceTicket($ticketId)
    {
        if (is_int($ticketId) === false)
        {
            throw new ApiException('Ticket ID must be an integer.');
        }

        ApiRequestParams::set('ticketNumber', $ticketId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetServiceTicket(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'GetServiceTicketResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Gets the count of service tickets that meet the specified conditions
     *
     * @param string $conditions
     * @param boolean $isOpen
     * @return array
     **/
    public static function getTicketCount($isOpen = true, $conditions = '')
    {
        if (is_bool($isOpen) === false)
        {
            throw new ApiException('isOpen parameter must be boolean.');
        }

        if (is_string($conditions) === false)
        {
            throw new ApiException('Conditions value must be a string.');
        }

        ApiRequestParams::set('conditions', $conditions);
        ApiRequestParams::set('isOpen', $isOpen);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetTicketCount(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'GetTicketCountResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Gets a service ticket by the ticket number.
     * If no service ticket exists with the given #, an error (exception) is thrown
     *
     * @throws ApiException
     * @param integer $ticketId
     * @return array
     **/
    public static function loadServiceTicket($ticketId)
    {
        if (is_int($ticketId) === false)
        {
            throw new ApiException('Ticket ID must be an integer.');
        }

        ApiRequestParams::set('ticketNumber', $ticketId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->LoadServiceTicket(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'LoadServiceTicketResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Get a list of products for the specified ticket
     *
     * @throws ApiException
     * @param integer $ticketNumber
     * @return array
     **/
    public static function getTicketProductList($ticketNumber)
    {
        if (is_int($ticketNumber) === false)
        {
            throw new ApiException('Ticket number must be an integer.');
        }

        ApiRequestParams::set('ticketNumber', $ticketNumber);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetTicketProductList(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->GetTicketProductListResult, 'TicketProduct');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Performs a Knowledgebase search using the specified parameters
     *
     * @throws ApiException
     * @param string $terms
     * @param string $type
     * @param string $start
     * @param integer $companyRecId
     * @param integer $limit
     * @param integer $skip
     * @return array
     **/
    public static function searchKnowledgebase($terms, $type, $start, $companyRecId = '', $limit = 100, $skip = 0)
    {
        if (is_int($limit) === false) 
        {
            throw new ApiException('Limit value must be an integer.');
        }

        if (is_int($skip) === false)
        {
            throw new ApiException('Skip value must be an integer.');
        }

        if (is_string($terms) === false)
        {
            throw new ApiException('Terms value must be a string.');
        }

        if (is_string($type) === false)
        {
            throw new ApiException('Type value must be a string.');
        }

        if (is_string($start) === false)
        {
            throw new ApiException('Start value must be a string.');
        }

        if ($type != 'Any' AND $type != 'All' AND $type != 'Exact')
        {
            throw new ApiException('KB type invalid. Must be "Any", "All" or "Exact".');
        }

        ApiRequestParams::set('searchTerms', $terms);
        ApiRequestParams::set('searchType', $type);
        ApiRequestParams::set('searchStart', $start);
        ApiRequestParams::set('companyRecID', $companyRecId);
        ApiRequestParams::set('limit', $limit);
        ApiRequestParams::set('skip', $skip);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->SearchKnowledgebase(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->SearchKnowledgebaseResult, 'KnowledgeBaseResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Counts the Knowledgebase records that will be returned by performing the associated search
     *
     * @throws ApiException
     * @param string $terms
     * @param string $type
     * @param string $start
     * @param integer $companyRecId
     * @return array
     **/
    public static function searchKnowledgebaseCount($terms, $type, $start, $companyRecId = '')
    {
        if (is_string($terms) === false)
        {
            throw new ApiException('Terms value must be a string.');
        }

        if (is_string($type) === false)
        {
            throw new ApiException('Type value must be a string.');
        }

        if (is_string($start) === false)
        {
            throw new ApiException('Start value must be a string.');
        }

        if ($type != 'Any' AND $type != 'All' AND $type != 'Exact')
        {
            throw new ApiException('KB type invalid. Must be "Any", "All" or "Exact".');
        }

        ApiRequestParams::set('searchTerms', $terms);
        ApiRequestParams::set('searchType', $type);
        ApiRequestParams::set('searchStart', $start);
        ApiRequestParams::set('companyRecID', $companyRecId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->SearchKnowledgebaseCount(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'SearchKnowledgebaseCountResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Get the documents attached to the specified ticket
     *
     * @throws ApiException
     * @param integer $ticketNumber
     * @return array
     **/
    public static function getTicketDocuments($ticketNumber)
    {
        if (is_int($ticketNumber) === false)
        {
            throw new ApiException('Ticket number must be an integer.');
        }

        ApiRequestParams::set('ticketNumber', $ticketNumber);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->GetTicketDocuments(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results->GetTicketDocumentsResult, 'DocumentInfo');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Updates an existing service ticket for a company identified by the text-based company id
     *
     * @param string $companyId
     * @param array $serviceTicket
     * @return array
     **/
    public static function updateServiceTicketViaCompanyId($companyId, array $serviceTicket)
    {
        if (is_string($companyId) === false)
        {
            throw new ApiException('Start value must be a string.');
        }

        ApiRequestParams::set('companyId', $companyId);
        ApiRequestParams::set('serviceTicket', $serviceTicket);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->UpdateServiceTicketViaCompanyId(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'UpdateServiceTicketViaCompanyIdResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Updates an existing service ticket for a company identified by managed id
     * @todo This is untested: need a valid managed id to test this method
     *
     * @param string $managedId
     * @param array $serviceTicket
     * @return array
     **/
    public static function updateServiceTicketViaManagedId($managedId, array $serviceTicket)
    {
        if (is_string($managedId) === false)
        {
            throw new ApiException('Managed ID value must be a string.');
        }

        ApiRequestParams::set('managedId', $managedId);
        ApiRequestParams::set('serviceTicket', $serviceTicket);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->UpdateServiceTicketViaManagedId(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'UpdateServiceTicketViaManagedIdResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Add a new ticket note or update an existing ticket note by service ticket rec id
     *
     * @throws ApiException
     * @param array $ticket
     * @param integer $serviceRecId
     * @return array
     **/
    public static function updateTicketNote(array $note, $serviceRecId)
    {
        if (is_int($serviceRecId) === false)
        {
            throw new ApiException('Service Rec ID must be an integer.');
        }

        ApiRequestParams::set('note', $note);
        ApiRequestParams::set('srServiceRecid', $serviceRecId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->UpdateTicketNote(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'UpdateTicketNoteResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Update a product on a ticket
     *
     * @param array $product
     * @return array
     **/
    public static function updateTicketProduct(array $product)
    {
        ApiRequestParams::set('ticketProduct', $product);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->UpdateTicketProduct(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results, 'UpdateTicketProductResult');

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Deletes a service ticket by the ticket number
     *
     * @param integer $ticketId
     * @return array
     **/
    public static function deleteServiceTicket($ticketId)
    {
        if (is_int($ticketId) === false)
        {
            throw new ApiException('Ticket ID must be an integer.');
        }

        ApiRequestParams::set('ticketNumber', $ticketId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->DeleteServiceTicket(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results);

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Removes the document from the ticket
     *
     * @throws ApiException
     * @param integer $docId
     * @param integer $ticketId
     * @return array
     **/
    public static function deleteTicketDocument($docId, $ticketId)
    {
        if (is_int($docId) === false)
        {
            throw new ApiException('Document ID must be an integer.');
        }

        if (is_int($ticketId) === false)
        {
            throw new ApiException('Ticket ID must be an integer.');
        }

        ApiRequestParams::set('id', $docId);
        ApiRequestParams::set('ticketNumber', $ticketId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->DeleteTicketDocument(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results);

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }

    /**
     * Delete product from a ticket
     *
     * @throws ApiException
     * @param integer $productId
     * @param integer $ticketId
     * @return array
     **/
    public static function deleteTicketProduct($productId, $ticketId)
    {
        if (is_int($productId) === false)
        {
            throw new ApiException('Product ID must be an integer.');
        }

        if (is_int($ticketId) === false)
        {
            throw new ApiException('Ticket ID must be an integer.');
        }

        ApiRequestParams::set('id', $productId);
        ApiRequestParams::set('ticketNumber', $ticketId);

        try
        {
            $results = ApiResource::run('api_connection', 'start', static::$currentApi)
                ->DeleteTicketProduct(ApiRequestParams::getAll());

            ApiResult::addResultFromObject($results);

            return ApiResult::getAll();
        }
        catch (SoapFault $error)
        {
            throw new ApiException($error->getMessage());
        }
    }
}