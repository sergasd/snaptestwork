<?php

namespace TestWork\lib;

use TestWork\helpers\Naming;


class Repository
{
    protected $connection;

    protected $tableName = '';

    protected $className = '';

    protected $attributes = [];

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
        if (!method_exists($model, 'getId')) {
            throw new \Exception('Method "getId" not found in model');
        }

        if ($model->getId()) {
            $this->update($model);
        } else {
            $this->insert($model);
        }
    }

    protected function insert($model)
    {
        $attributes = $params = [];
        foreach ($this->attributes as $attribute) {
            $attributes[] = "$attribute = :$attribute";
            $params[":$attribute"] = $this->getAttributeFromModel($model, $attribute);
        }
        $sql = "INSERT INTO $this->tableName SET ";
        $sql .= implode(', ', $attributes);

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
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

} 