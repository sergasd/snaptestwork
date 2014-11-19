<?php

namespace TestWork\form;


use TestWork\lib\Form;
use TestWork\models\Video;

class VideoForm extends Form
{
    protected $model;

    protected $className = 'Video';

    public function __construct(Video $model)
    {
        $this->model = $model;
    }

    protected function applyRules()
    {
        $title = $this->model->getTitle();
        if (empty($title)) {
            $this->addError('Empty title');
        }
    }

} 