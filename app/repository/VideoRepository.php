<?php

namespace TestWork\repository;

use TestWork\lib\interfaces\ImageHandler;
use TestWork\lib\Repository;
use TestWork\lib\UploadedFile;
use TestWork\models\Genre;
use TestWork\models\Video;


class VideoRepository extends Repository
{

    protected $tableName = 'video';

    protected $className = 'TestWork\\models\\Video';

    protected $attributes = ['title', 'original_title', 'country'];

    private $genreRepository;

    private $imageHandler;

    public function __construct(\PDO $connection, GenreRepository $genreRepository, ImageHandler $imageHandler)
    {
        parent::__construct($connection);
        $this->genreRepository = $genreRepository;
        $this->imageHandler = $imageHandler;
    }

    /**
     * @param Video $model
     * @throws \Exception
    */
    public function save($model)
    {
        $this->getConnection()->beginTransaction();

        try {
            parent::save($model);
            $this->saveGenres($model);
            $this->saveImage($model);

            $this->getConnection()->commit();
        } catch (\Exception $e) {
            $this->getConnection()->rollBack();
            throw $e;
        }
    }

    public function delete($model)
    {
        $this->getConnection()->beginTransaction();

        try {
            parent::delete($model);
            $this->deleteImage($model);

            $this->getConnection()->commit();
        } catch (\Exception $e) {
            $this->getConnection()->rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * @param Video $model
    */
    private function saveImage($model)
    {
        $image = $model->getImage();
        if (!$image instanceof UploadedFile) {
            return;
        }

        $originalSize = getimagesize($image->getTmpName());
        $sizes = [
            'original' => [$originalSize[0], $originalSize[1]],
            'small' => [100, 145],
            'middle' => [150, 218]
        ];

        $imagesDir = dirname($model->getImagePath());
        if (!is_dir($imagesDir)) {
            mkdir($imagesDir, 0777, true);
        }

        foreach ($sizes as $sizeName => $dimensions) {
            $targetFile = "$imagesDir/$sizeName.png";
            $this->imageHandler->resize($image->getTmpName(), $targetFile, $dimensions[0], $dimensions[1]);
        }
    }

    /**
     * @param Video $model
     */
    private function deleteImage($model)
    {
        $imagesDir = dirname($model->getImagePath());
        if (!is_dir($imagesDir)) {
            return;
        }

        foreach (glob("$imagesDir/*") as $file) {
            unlink($file);
        }
        rmdir($imagesDir);
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