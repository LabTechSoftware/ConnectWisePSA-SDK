<?php namespace LabtechSoftware\ConnectwisePsaSdk;

use LabtechSoftware\ConnectwisePsaSdk\ApiException;

/**
 * ConnectWise Service Ticket API
 *
 * @package ConnectwisePsaSdk
 */
class ServiceTicket
{
    private $client;

    public function __construct(ConnectWiseApi $client)
    {
        $this->client = $client;
    }
    
    /**
     * Adds or updates a service ticket for a company identified by the text-based company id.
     * If the service ticket number is 0, the service ticket is added.
     * If non-zero, the existing service ticket with that ticket number is updated.
     *
     * @throws ApiException
     * @param string $companyId
     * @param array $serviceTicket
     * @return array
     **/
    public function addOrUpdateServiceTicketViaCompanyId($companyId, array $serviceTicket)
    {
        if (is_string($companyId) === false) {
            throw new ApiException('Company ID must be a string.');
        }

        $params = array(
            'companyId' => $companyId,
            'serviceTicket' => $serviceTicket
        );

        return $this->client->makeRequest('AddOrUpdateServiceTicketViaCompanyId', $params);
    }

    /**
     * Adds or updates a service ticket for a company identified by managed id.
     * If the service ticket number is 0, the service ticket is added.
     * If non-zero, the existing service ticket with that ticket number is updated.
     * @todo This is untested: need a valid managed id to test this method
     *
     * @throws ApiException
     * @param string $managedId
     * @param array $serviceTicket
     * @return array
     **/
    public function addOrUpdateServiceTicketViaManagedId($managedId, array $serviceTicket)
    {
        if (is_string($managedId) === false) {
            throw new ApiException('Managed ID must be a string.');
        }

        $params = array(
            'manageId' => $managedId,
            'serviceTicket' => $serviceTicket
        );

        return $this->client->makeRequest('AddOrUpdateServiceTicketViaManagedId', $params);
    }

    /**
     * Add or update a product on a ticket
     *
     * @param array $ticketProduct
     * @return array
     **/
    public function addOrUpdateTicketProduct(array $ticketProduct)
    {
        $params = array(
            'ticketProduct' => $ticketProduct
        );

        return $this->client->makeRequest('AddOrUpdateTicketProduct', $params);
    }

    /**
     * Finds service ticket information by a set of conditions
     *
     * @throws ApiException
     * @param int $limit
     * @param int $skip
     * @param string $conditions
     * @param string $orderBy
     * @return array
     */
    public function findServiceTickets($limit = 100, $skip = 0, $conditions = '', $orderBy = '')
    {
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
            'skip' => $skip,
            'conditions' => $conditions,
            'orderBy' => $orderBy
        );

        // only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        return $this->client->makeRequest('FindServiceTickets', $params);
    }

    /**
     * Gets the list of statuses available to the specified ticket
     *
     * @throws ApiException
     * @param int $ticketId
     * @return array
     **/
    public function getServiceStatuses($ticketId)
    {
        if (is_numeric($ticketId) === false) {
            throw new ApiException('Ticket ID must be numeric.');
        }

        $params = array(
            'ticketNumber' => $ticketId
        );

        return $this->client->makeRequest('GetServiceStatuses', $params);
    }

    /**
     * Gets a service ticket by the ticket number (id)
     * If no service ticket exists with the given ticket number, an empty array is returned
     *
     * @throws ApiException
     * @param int $ticketId
     * @return array
     **/
    public function getServiceTicket($ticketId)
    {
        if (is_numeric($ticketId) === false) {
            throw new ApiException('Ticket ID must be numeric.');
        }

        $params = array(
            'ticketNumber' => $ticketId
        );

        return $this->client->makeRequest('GetServiceTicket', $params);
    }

    /**
     * Gets the count of service tickets that meet the specified conditions
     *
     * @throws ApiException
     * @param string $conditions
     * @return array
     **/
    public function getTicketCount($conditions = '')
    {
        if (is_string($conditions) === false) {
            throw new ApiException('Conditions value must be a string.');
        }

        $params = array(
            'conditions' => $conditions,
        );

        return $this->client->makeRequest('GetTicketCount', $params);
    }

    /**
     * Get a list of products for the specified ticket
     *
     * @throws ApiException
     * @param int $ticketNumber
     * @return array
     **/
    public function getTicketProductList($ticketNumber)
    {
        if (is_numeric($ticketNumber) === false) {
            throw new ApiException('Ticket number must be numeric.');
        }

        $params = array(
            'ticketNumber' => $ticketNumber
        );

        return $this->client->makeRequest('GetTicketProductList', $params);
    }

    /**
     * Performs a Knowledgebase search using the specified parameters
     *
     * @throws ApiException
     * @param string $terms
     * @param string $type
     * @param string $start
     * @param int $companyRecId
     * @param int $limit
     * @param int $skip
     * @return array
     **/
    public function searchKnowledgebase($terms, $type, $start, $companyRecId = 0, $limit = 100, $skip = 0)
    {
        if (is_string($terms) === false) {
            throw new ApiException('Terms value must be a string.');
        }

        if (is_string($type) === false) {
            throw new ApiException('Type value must be a string.');
        }

        if ($type != 'Any' && $type != 'All' && $type != 'Exact') {
            throw new ApiException('KB type invalid. Must be "Any", "All" or "Exact".');
        }

        if (is_string($start) === false) {
            throw new ApiException('Start value must be a string.');
        }

        if (is_numeric($companyRecId) === false) {
            throw new ApiException('CompanyRecId value must be numeric');
        }

        if (is_numeric($limit) === false) {
            throw new ApiException('Limit value must be numeric.');
        }

        if (is_numeric($skip) === false) {
            throw new ApiException('Skip value must be numeric.');
        }

        $params = array(
            'searchTerms' => $terms,
            'searchType' => $type,
            'searchStart' => $start,
            'companyRecID' => $companyRecId,
            'skip' => $skip
        );

        // only set limit if there is a limit, limit 0 will return no results
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        return $this->client->makeRequest('SearchKnowledgebase', $params);
    }

    /**
     * Counts the Knowledgebase records that will be returned by performing the associated search
     *
     * @throws ApiException
     * @param string $terms
     * @param string $type
     * @param string $start
     * @param int $companyRecId
     * @return array
     **/
    public function searchKnowledgebaseCount($terms, $type, $start, $companyRecId = 0)
    {
        if (is_string($terms) === false) {
            throw new ApiException('Terms value must be a string.');
        }

        if (is_string($type) === false) {
            throw new ApiException('Type value must be a string.');
        }

        if ($type != 'Any' && $type != 'All' && $type != 'Exact') {
            throw new ApiException('KB type invalid. Must be "Any", "All" or "Exact".');
        }

        if (is_string($start) === false) {
            throw new ApiException('Start value must be a string.');
        }

        if (is_numeric($companyRecId) === false) {
            throw new ApiException('CompanyRecId value must be numeric');
        }


        $params = array(
            'searchTerms' => $terms,
            'searchType' => $type,
            'searchStart' => $start,
            'companyRecID' => $companyRecId
        );

        return $this->client->makeRequest('searchKnowledgebaseCount', $params);
    }

    /**
     * Get the documents attached to the specified ticket
     *
     * @throws ApiException
     * @param int $ticketNumber
     * @return array
     **/
    public function getTicketDocuments($ticketNumber)
    {
        if (is_numeric($ticketNumber) === false) {
            throw new ApiException('Ticket number must be numeric.');
        }

        $params = array(
            'ticketNumber' => $ticketNumber
        );

        return $this->client->makeRequest('GetTicketDocuments', $params);
    }

    /**
     * Add a new ticket note or update an existing ticket note by service ticket rec id
     *
     * @throws ApiException
     * @param array $note
     * @param int $serviceRecId
     * @return array
     **/
    public function updateTicketNote(array $note, $serviceRecId)
    {
        if (is_numeric($serviceRecId) === false) {
            throw new ApiException('Service Rec ID must be numeric.');
        }

        $params = array(
            'note' => $note,
            'srServiceRecid' => $serviceRecId
        );

        return $this->client->makeRequest('UpdateTicketNote', $params);
    }

    /**
     * Deletes a service ticket by the ticket number
     *
     * @throws ApiException
     * @param int $ticketId
     * @return array
     **/
    public function deleteServiceTicket($ticketId)
    {
        if (is_numeric($ticketId) === false) {
            throw new ApiException('Ticket ID must be numeric.');
        }

        $params = array(
            'ticketNumber' => $ticketId
        );

        return $this->client->makeRequest('DeleteServiceTicket', $params);
    }

    /**
     * Removes the document from the ticket
     *
     * @throws ApiException
     * @param int $docId
     * @param int $ticketId
     * @return array
     **/
    public function deleteTicketDocument($docId, $ticketId)
    {
        if (is_numeric($docId) === false) {
            throw new ApiException('Document ID must be numeric.');
        }

        if (is_numeric($ticketId) === false) {
            throw new ApiException('Ticket ID must be numeric.');
        }

        $params = array(
            'id' => $docId,
            'ticketNumber' => $ticketId
        );

        return $this->client->makeRequest('DeleteTicketDocument', $params);
    }

    /**
     * Delete product from a ticket
     *
     * @throws ApiException
     * @param int $productId
     * @param int $ticketId
     * @return array
     **/
    public function deleteTicketProduct($productId, $ticketId)
    {
        if (is_numeric($productId) === false) {
            throw new ApiException('Product ID must be numeric.');
        }

        if (is_numeric($ticketId) === false) {
            throw new ApiException('Ticket ID must be numeric.');
        }

        $params = array(
            'id' => $productId,
            'ticketNumber' => $ticketId
        );

        return $this->client->makeRequest('DeleteTicketProduct', $params);
    }
}
