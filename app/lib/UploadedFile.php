<?php

namespace TestWork\lib;


class UploadedFile
{
    private $name;

    private $type;

    private $tmpName;

    private $error;

    private $size;

    public function __construct($name, $type, $tmpName, $error, $size)
    {
        $this->name = $name;
        $this->type = $type;
        $this->tmpName = $tmpName;
        $this->error = $error;
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getTmpName()
    {
        return $this->tmpName;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

} 