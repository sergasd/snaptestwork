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
        /** @var VideoRepository $videoRepository */
        $videoRepository = $this->container->get('repository.video');
        $videos = $videoRepository->findBy([]);

        return $this->render('video/list', [
            'videos' => $videos,
        ]);
    }

    public function addAction()
    {
        /** @var $repository VideoRepository */
        $repository = $this->container->get('repository.video');
        $video = new Video();
        $form = new VideoForm($video);

        if ($form->load($_POST) && $form->isValid()) {
            $repository->save($video);
            $this->redirect('?r=video/index');
        }

        return $this->render('video/create', [
            'video' => $video,
            'form' => $form,
        ]);
    }

} 