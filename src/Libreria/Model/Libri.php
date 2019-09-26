<?php


namespace Libreria\Model;


use Doctrine\DBAL\Connection;

class Libri
{
    /** @var Connection */
    private $connection;

    /**
     * Libri constructor.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function read()
    {
        $selectStatement = 'SELECT * FROM libri';
        return $this->connection->fetchAll($selectStatement);
    }

}
