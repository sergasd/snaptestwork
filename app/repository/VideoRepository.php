<?php

namespace TestWork\repository;

use TestWork\lib\Repository;



class VideoRepository extends Repository
{

    protected $tableName = 'video';

    protected $className = 'TestWork\\models\\Genre';

    protected $attributes = ['title', 'original_title', 'country'];

}