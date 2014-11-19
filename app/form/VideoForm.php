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
        $title = $this->model->getTitle();
        if (empty($title)) {
            $this->addError('Empty title');
        }
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