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

    public function insert($titolo, $autore, $prezzo)
    {
        $insertStatement = "INSERT INTO libri (title, author, price) VALUES ('$titolo', '$autore', $prezzo)";
        return $this->connection->exec($insertStatement);
    }

}
