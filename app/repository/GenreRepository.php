<?php

namespace TestWork\repository;

use TestWork\lib\Repository;

class GenreRepository extends Repository
{

    protected $tableName = 'genre';

    protected $className = 'TestWork\\models\\Genre';

    protected $attributes = ['name'];

} 