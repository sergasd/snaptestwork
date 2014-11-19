<?php

namespace TestWork\form;


use TestWork\lib\Form;
use TestWork\models\Video;
use TestWork\repository\GenreRepository;

class VideoForm extends Form
{
    protected $model;

    protected $genreRepository;

    protected $className = 'Video';

    public function __construct(Video $model, GenreRepository $genreRepository)
    {
        $this->model = $model;
        $this->genreRepository = $genreRepository;
        $this->setGenresString();
    }

    protected function applyRules()
    {
        $this->applyRule('title', 'required');
        $this->applyRule('country', 'required');
        $this->applyRule('begin_year', 'required');
        $this->applyRule('begin_year', 'number');
        $this->applyRule('end_year', 'required');
        $this->applyRule('end_year', 'number');
        $this->applyRule('producer', 'required');
        $this->applyRule('actors', 'required');
        $this->applyRule('duration', 'required');
        $this->applyRule('duration', 'number');
        $this->applyRule('anons', 'required');
        $this->applyRule('description', 'required');
    }

    protected function afterLoad($data)
    {
        $image = $this->getFile('image');
        if ($image) {
            $this->model->setImage($image);
        }
    }

    private function setGenresString()
    {
        if ($this->model->getId()) {
            $genres = [];
            foreach ($this->genreRepository->findGenresFor($this->model) as $genre) {
                $genres[] = $genre->getName();
            }

            $this->model->setGenresString(implode(', ', $genres));
        }
    }

} 