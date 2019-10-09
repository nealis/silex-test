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

    public function read($filters, $page, $column, $order)
    {
        $offset = ($page - 1) * 5;
        $titolo = array_key_exists('titolo', $filters) ? $filters['titolo'] : '';
        $autore = array_key_exists('autore', $filters) ? $filters['autore'] : '';
        $queryCount = "SELECT COUNT(id) AS count_id FROM libro WHERE title LIKE '$titolo%' AND author LIKE '$autore%'";
        $countStatement = $this->connection->fetchAssoc($queryCount);
        $countStatement = intval($countStatement['count_id']);
        $selectStatement = "SELECT * FROM libro WHERE title LIKE '$titolo%' AND author LIKE '$autore%' ORDER BY $column $order LIMIT 5 OFFSET $offset";
        return array ($this->connection->fetchAll($selectStatement), $countStatement);
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
