<?php

namespace TestWork\models;

use TestWork\helpers\Date;
use TestWork\lib\Application;
use TestWork\lib\UploadedFile;

class Video
{

    private $id;

    private $title;

    private $original_title;

    private $country;

    private $begin_year;

    private $end_year;

    private $producer;

    private $actors;

    private $duration;

    private $premiere_date;

    private $anons;

    private $description;


    private $genresString;

    /**
     * @var UploadedFile
    */
    private $image;

    public function getId()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getOriginalTitle()
    {
        return $this->original_title;
    }

    public function setOriginalTitle($originalTitle)
    {
        $this->original_title = $originalTitle;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getBeginYear()
    {
        return $this->begin_year;
    }

    public function setBeginYear($beginYear)
    {
        $this->begin_year = $beginYear;
    }

    public function getEndYear()
    {
        return $this->end_year;
    }

    public function setEndYear($endYear)
    {
        $this->end_year = $endYear;
    }

    public function getProducer()
    {
        return $this->producer;
    }

    public function setProducer($producer)
    {
        $this->producer = $producer;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getActors()
    {
        return $this->actors;
    }

    public function setActors($actors)
    {
        $this->actors = $actors;
    }

    public function getPremiereDate()
    {
        return $this->premiere_date;
    }

    public function getPremiereDateFormatted()
    {
        return Date::dateToHuman($this->premiere_date);
    }

    public function setPremiereDate($premiereDate)
    {
        $this->premiere_date = $premiereDate;
    }

    public function getAnons()
    {
        return $this->anons;
    }

    public function setAnons($anons)
    {
        $this->anons = $anons;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getGenresString()
    {
        return $this->genresString;
    }

    public function setGenresString($genresString)
    {
        $this->genresString = $genresString;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImagePath($sizeName = 'original')
    {
        return Application::getContainer()->getParam('webPath') . '/files/video/' . $this->getId() . '/' . $sizeName . '.png';
    }

    public function getImageUrl($sizeName = 'original')
    {
        $webPath = Application::getContainer()->getParam('webPath');
        $baseUrl = Application::getContainer()->getParam('baseUrl');
        return $baseUrl . str_replace($webPath, '', $this->getImagePath($sizeName));
    }

} 