<?php


namespace TestWork\controllers;

use TestWork\lib\Controller;

class VideoController extends Controller
{

    public function indexAction()
    {
        return $this->render('video/list');
    }

} 