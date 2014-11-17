<?php

namespace TestWork\form;


use TestWork\lib\Form;
use TestWork\models\Genre;
use TestWork\repository\GenreRepository;

class GenreForm extends Form
{
    protected $model;

    protected $genreRepository;

    protected $className = 'Genre';

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

}
