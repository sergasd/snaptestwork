<?php

namespace TestWork\lib;


abstract class Form
{
    protected $model;

    protected $errors = [];

    protected $className = '';

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function addError($error)
    {
        $this->errors[] = $error;
    }

    public function isValid()
    {
        $this->errors = [];
        $this->applyRules();
        return !$this->hasErrors();
    }

    public function load($data)
    {
        if (!isset($data[$this->className])) {
            return false;
        }

        foreach ( $data[$this->className] as $name => $value) {
            $methodName = 'set' . ucfirst($name);

            if (method_exists($this->model, $methodName)) {
                $this->model->$methodName($value);
            }
        }

        $this->errors = [];
        return true;
    }

    abstract protected function applyRules();

} 