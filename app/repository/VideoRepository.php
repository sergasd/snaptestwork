<?php

namespace TestWork\repository;

use TestWork\lib\Repository;
use TestWork\models\Genre;
use TestWork\models\Video;


class VideoRepository extends Repository
{

    protected $tableName = 'video';

    protected $className = 'TestWork\\models\\Genre';

    protected $attributes = ['title', 'original_title', 'country'];

    private $genreRepository;

    public function __construct(\PDO $connection, GenreRepository $genreRepository)
    {
        parent::__construct($connection);
        $this->genreRepository = $genreRepository;
    }

    /**
     * @param Video $model
    */
    public function save($model)
    {
        $this->getConnection()->beginTransaction();

        try {
            parent::save($model);
            $this->saveGenres($model);
            $this->getConnection()->commit();
        } catch (\Exception $e) {
            $this->getConnection()->rollBack();
        }
    }


    /**
     * @param Video $model
    */
    private function saveGenres($model)
    {
        $genres = preg_split('~[,\s]+~', $model->getGenresString());
        $genres = array_filter(array_unique($genres));

        $stmt = $this->getConnection()->prepare("DELETE FROM video_to_genre WHERE video_id = :video_id");
        $stmt->execute([':video_id' => $model->getId()]);

        /** @var $relatedGenres Genre[] */
        $relatedGenres = $this->genreRepository->findBy(['name' => $genres]);
        $relatedGenres = $this->indexBy($relatedGenres, 'name');

        // create new genres
        foreach ($genres as $genre) {
            if (!array_key_exists($genre, $relatedGenres)) {
                $newGenre = new Genre();
                $newGenre->setName($genre);
                $this->genreRepository->save($newGenre);
                $relatedGenres[$newGenre->getName()] = $newGenre;
            }
        }

        // may be optimize with multi insert if needed
        $stmt = $this->getConnection()->prepare("INSERT INTO video_to_genre SET video_id = :video_id, genre_id = :genre_id");
        foreach ($relatedGenres as $relatedGenre) {
            $stmt->execute([
                ':video_id' => $model->getId(),
                ':genre_id' => $relatedGenre->getId()
            ]);
        }
    }

}