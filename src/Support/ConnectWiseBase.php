<?php namespace LabtechSoftware\ConnectwisePsaSdk\Support;

use LabtechSoftware\ConnectwisePsaSdk\Support\Contracts\ConnectionInterface;

/**
 * Abstract/base class for all CW Web Services classes
 */
class ConnectWiseBase
{
    /**
     * Connection object
     *
     * @var ConnectionInterface
     **/
    protected $connection;

    /**
     * Bind the connection object
     *
     * @param ConnectionInterface $connection
     * @return void
     **/
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return the connection instance
     *
     * @return ConnectionInterface
     **/
    protected function getConnection()
    {
        return $this->connection;
    }
}