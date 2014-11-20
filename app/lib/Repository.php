<?php

namespace TestWork\lib;

use TestWork\helpers\Naming;


class Repository
{
    protected $connection;

    protected $tableName = '';

    protected $className = '';

    protected $attributes = [];

    private static $inCounter = 0;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    protected function getConnection()
    {
        return $this->connection;
    }

    public function save($model)
    {
        $this->checkModel($model);

        if ($model->getId()) {
            $this->update($model);
        } else {
            $this->insert($model);
        }
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM $this->tableName WHERE id = :id LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);
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
                $sql .= " AND " . $this->generateInCondition($name, $value, $params);
            } else {
                $sql .= " AND $name = $paramName";
                $params[$paramName] = $value;
            }
        }

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);
    }

    public function delete($model)
    {
        $this->checkModel($model);
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([':id' => $model->getId()]);
    }

    protected function insert($model)
    {
        $params = [];
        $sql = "INSERT INTO $this->tableName SET " . $this->generateSetClause($model, $params);
        $stmt = $this->getConnection()->prepare($sql);

        if ($stmt->execute($params)) {
            $this->setId($model);
        }
    }

    protected function update($model)
    {
        // todo
    }

    protected function getAttributeFromModel($model, $attribute)
    {
        $getter = Naming::toCamelCase('get' . ucfirst($attribute));
        if (method_exists($model, $getter)) {
            return $model->$getter();
        }
    }

    protected function indexBy($data, $attribute = 'id')
    {
        $indexed = [];
        $getter = Naming::toCamelCase('get' . ucfirst($attribute));
        foreach ($data as $item) {
            if (method_exists($item, $getter)) {
                $indexed[$item->$getter()] = $item;
            }
        }

        return $indexed;
    }

    private function setId($model)
    {
        $reflection = new \ReflectionObject($model);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($model, $this->getConnection()->lastInsertId());
        $property->setAccessible(false);
    }

    private function checkModel($model)
    {
        if (!method_exists($model, 'getId')) {
            throw new \Exception('Method "getId" not found in model');
        }
    }

    private function generateInCondition($name, $values, &$params)
    {
        if (empty($values)) {
            return '0 = 1';
        }

        $counter =  ++self::$inCounter;
        $inValues = [];
        foreach ($values as $key => $value) {
            $key = (int) $key;
            $paramName = ":in_{$counter}_{$key}";
            $inValues[] = $paramName;
            $params[$paramName] = $value;
        }

        return "$name IN (" . implode(', ', $inValues) . ')';
    }

    private function generateSetClause($model, &$params)
    {
        $attributes = [];
        foreach ($this->attributes as $attribute) {
            $attributes[] = "$attribute = :$attribute";
            $params[":$attribute"] = $this->getAttributeFromModel($model, $attribute);
        }

        return implode(', ', $attributes);
    }

} 