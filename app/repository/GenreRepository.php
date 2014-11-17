<?php

namespace TestWork\repository;

use TestWork\lib\Repository;
use TestWork\models\Genre;

class GenreRepository extends Repository
{

    protected $tableName = 'genre';

    protected $className = 'TestWork\\models\\Genre';

    protected $attributes = ['id', 'name'];

    public function save(Genre $model)
    {

        if ($model->getId()) {
            $this->update($model);
        } else {
            $this->insert($model);
        }

    }

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


    protected function update(Genre $model)
    {
        $sql = "UPDATE $this->tableName SET name = :name WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $params = [
            ':id' => $model->getId(),
        ];
        return $stmt->execute($params);
    }

    protected function insert(Genre $model)
    {
        $sql = "INSERT INTO $this->tableName SET name = :name";
        $stmt = $this->connection->prepare($sql);
        $params = [
            ':name' => $model->getName(),
        ];
        $stmt->execute($params);
        //set id with reflection
    }



} 