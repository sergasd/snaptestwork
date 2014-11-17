<?php

namespace TestWork\form;


use TestWork\models\Genre;
use TestWork\repository\GenreRepository;

class GenreForm
{
    protected $model;

    protected $genreRepository;

    protected $className = 'Genre';

    protected $errors = [];

    public function __construct(Genre $model, GenreRepository $genreRepository)
    {
        $this->model = $model;
        $this->genreRepository = $genreRepository;
    }

    public function isValid()
    {
        if (mb_strlen($this->model->getName()) < 3) {
            $this->addError('Min length error < 3');
        }

        $existsGenre = $this->genreRepository->findBy(['name' => $this->model->getName()]);
        if (count($existsGenre)) {
            $this->addError('Already exists');
        }

        return !$this->hasErrors();
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    public function getErrors()
    {
        return $this->errors;
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

    protected function addError($error)
    {
        $this->errors[] = $error;
    }


} 