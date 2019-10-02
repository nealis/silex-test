<?php


namespace Libreria\Model;


use Doctrine\DBAL\Connection;

class Libro
{
    /** @var Connection */
    private $connection;

    /**
     * Libro constructor.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function read()
    {
        $selectStatement = 'SELECT * FROM libro';
        return $this->connection->fetchAll($selectStatement);
    }

    public function readById($id)
    {
        $selectStatement = "SELECT * FROM libro WHERE id = $id";
        return $this->connection->fetchAssoc($selectStatement);
    }

    public function insert($titolo, $autore, $prezzo)
    {
        $insertStatement = "INSERT INTO libro (title, author, price) VALUES ('$titolo', '$autore', $prezzo)";
        return $this->connection->exec($insertStatement);
    }

    public function delete($id)
    {
        $deleteStatement = "DELETE FROM libro WHERE id = $id";
        return $this->connection->exec($deleteStatement);
    }

    public function edit($id, $titolo, $autore, $prezzo)
    {
        $editStatement = "UPDATE libro SET title = '$titolo', author = '$autore', price = $prezzo WHERE id = $id";
        return $this->connection->exec($editStatement);
    }
}
