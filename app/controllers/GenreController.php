<?php

namespace TestWork\controllers;

use TestWork\form\GenreForm;
use TestWork\lib\Controller;
use TestWork\models\Genre;

class GenreController extends Controller
{

    public function indexAction()
    {
        return $this->render('genre/list');
    }

    public function addAction()
    {
        $repository = $this->container->get('repository.genre');
        $genre = new Genre();
        $form = new GenreForm($genre, $repository);

        if ($form->load($_POST) && $form->isValid()) {
            $repository->save($genre);
            $this->redirect('?r=genre/index');
        }

        return $this->render('genre/create', [
            'genre' => $genre,
            'form' => $form,
        ]);
    }

} 