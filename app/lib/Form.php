<?php

namespace TestWork\lib;

use TestWork\helpers\Naming;
use TestWork\lib\UploadedFile;

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
            $methodName = Naming::toCamelCase('set' . ucfirst($name));

            if (method_exists($this->model, $methodName)) {
                $this->model->$methodName($value);
            }
        }

        $this->errors = [];
        return true;
    }

    /**
     * @return UploadedFile
    */
    protected function getFile($name)
    {
        if (!empty($_FILES[$this->className]['tmp_name'][$name])) {
            return new UploadedFile(
                $_FILES[$this->className]['name'][$name],
                $_FILES[$this->className]['type'][$name],
                $_FILES[$this->className]['tmp_name'][$name],
                $_FILES[$this->className]['error'][$name],
                $_FILES[$this->className]['size'][$name]
            );
        }
    }

    abstract protected function applyRules();

} 