<?php


namespace TestWork\controllers;

use TestWork\lib\Controller;
use TestWork\models\Video;
use TestWork\form\VideoForm;
use TestWork\repository\VideoRepository;

class VideoController extends Controller
{

    public function indexAction()
    {
        return $this->render('video/list', [
            'videos' => $this->getVideoRepository()->findBy([]),
        ]);
    }

    public function addAction()
    {
        $video = new Video();
        $form = new VideoForm($video);

        if ($form->load($_POST) && $form->isValid()) {
            $this->getVideoRepository()->save($video);
            $this->redirect('?r=video/index');
        }

        return $this->render('video/create', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    /**
     * @return VideoRepository
    */
    private function getVideoRepository()
    {
        return $this->container->get('repository.video');
    }
} 