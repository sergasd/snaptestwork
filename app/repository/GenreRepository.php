<?php

namespace TestWork\repository;

use TestWork\lib\Repository;
use TestWork\models\Genre;

class GenreRepository extends Repository
{

    protected $tableName = 'genre';

    protected $className = 'TestWork\\models\\Genre';

    protected $attributes = ['name'];

    private static $inCounter = 0;

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
            if (!in_array($name, $this->attributes)) {
                continue;
            }

            $paramName = ":$name";

            if (is_array($value)) {
                $sql .= " AND $name IN (" . $this->generateInCondition($value, $params) . ')';
            } else {
                $sql .= " AND $name = $paramName";
                $params[$paramName] = $value;
            }
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);
    }

    private function generateInCondition($values, &$params)
    {
        if (empty($values)) {
            return 'FALSE';
        }

        $counter =  ++self::$inCounter;
        $inValues = [];
        foreach ($values as $key => $value) {
            $key = (int) $key;
            $paramName = ":in_{$counter}_{$key}";
            $inValues[] = $paramName;
            $params[$paramName] = $value;
        }

        return implode(', ', $inValues);
    }

} 