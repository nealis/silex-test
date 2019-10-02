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

    public function delete($id)
    {
        $deleteStatement = "DELETE FROM libri WHERE id = $id";
        return $this->connection->exec($deleteStatement);
    }

    public function edit($id, $titolo, $autore, $prezzo)
    {
        $editStatement = "UPDATE libri SET title = '$titolo', author = '$autore', price = $prezzo WHERE id = $id";
        return $this->connection->exec($editStatement);
    }
}
