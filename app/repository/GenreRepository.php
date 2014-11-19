<?php

namespace TestWork\repository;

use TestWork\lib\Repository;
use TestWork\models\Genre;
use TestWork\models\Video;

class GenreRepository extends Repository
{

    protected $tableName = 'genre';

    protected $className = 'TestWork\\models\\Genre';

    protected $attributes = ['name'];

    /**
     * @param Video $model
     * @return Genre[]
    */
    public function findGenresFor($model)
    {
        $sql = "SELECT genre.*
        FROM genre INNER JOIN video_to_genre ON genre.id = video_to_genre.genre_id
        WHERE video_to_genre.video_id = :video_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([':video_id' => $model->getId()]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);
    }

} 