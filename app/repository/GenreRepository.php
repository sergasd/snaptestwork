<?php

namespace TestWork\repository;

use TestWork\lib\Repository;
use TestWork\models\Genre;

class GenreRepository extends Repository
{

    protected $tableName = 'genre';

    protected $className = 'TestWork\\models\\Genre';

    protected $attributes = ['name'];


    public function findById($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchObject($this->className);
    }

    public function findBy($attributes)
    {
        $sql = "SELECT * FROM $this->tableName WHERE 1 ";
        $params = [];
        foreach ($attributes as $name => $value) {
            if (in_array($name, $this->attributes)) {
                $paramName = ":$name";
                $sql .= " AND $name = $paramName";
                $params[$paramName] = $value;
            }
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);
    }

} 