<?php
use TestWork\helpers\Html;
/**
 * @var \TestWork\models\Video $video
 * @var \TestWork\form\VideoForm $form
*/
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>genre create</title>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css"/>
</head>
<body>
    <div class="container">
        <a class="btn btn-default" href="?r=video/index">back</a>

        <?php if ($form->hasErrors()): ?>
            <div class="bg-danger">
                <?php foreach ($form->getErrors() as $error):?>
                    <div class="error"><?=Html::encode($error)?></div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <form action="" method="post" enctype="multipart/form-data" role="form">
            <div class="form-group">
                <label for="Video_title">Title</label>
                <input class="form-control" type="text" name="Video[title]" id="Video_title" value="<?=Html::encode($video->getTitle())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_original_title">Original Title</label>
                <input class="form-control" type="text" name="Video[original_title]" id="Video_original_title" value="<?=Html::encode($video->getOriginalTitle())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_country">Country</label>
                <input class="form-control" type="text" name="Video[country]" id="Video_country" value="<?=Html::encode($video->getCountry())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_image">Image</label>
                <input type="file" name="Video[image]" id="Video_image" />

                <?php if ($video->getId() && $video->getImageUrl('middle')): ?>
                    <div class="video-image">
                        <img src="<?=Html::encode($video->getImageUrl('middle'))?>" alt="image"/>
                    </div>
                <?php endif ?>
            </div>

            <div class="form-group">
                <label for="Video_genres_string">Genres</label>
                <input class="form-control" type="text" name="Video[genres_string]" id="Video_genres_string" value="<?=Html::encode($video->getGenresString())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_begin_year">begin year</label>
                <input class="form-control" type="text" name="Video[begin_year]" id="Video_begin_year" value="<?=Html::encode($video->getBeginYear())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_end_year">end year</label>
                <input class="form-control" type="text" name="Video[end_year]" id="Video_end_year" value="<?=Html::encode($video->getEndYear())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_producer">producer</label>
                <input class="form-control" type="text" name="Video[producer]" id="Video_producer" value="<?=Html::encode($video->getProducer())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_actors">actors</label>
                <input class="form-control" type="text" name="Video[actors]" id="Video_actors" value="<?=Html::encode($video->getActors())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_duration">duration</label>
                <input class="form-control" type="text" name="Video[duration]" id="Video_duration" value="<?=Html::encode($video->getDuration())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_premiere_date">Premiere date</label>
                <input class="form-control" type="text" name="Video[premiere_date]" id="Video_premiere_date" value="<?=Html::encode($video->getPremiereDateFormatted())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_anons">anons</label>
                <input class="form-control" type="text" name="Video[anons]" id="Video_anons" value="<?=Html::encode($video->getAnons())?>"/>
            </div>

            <div class="form-group">
                <label for="Video_description">description</label>
                <input class="form-control" type="text" name="Video[description]" id="Video_description" value="<?=Html::encode($video->getDescription())?>"/>
            </div>

            <div class="form-group">
                <input  class="btn btn-primary" type="submit" value="submit"/>
            </div>
        </form>

    </div>
</body>
</html>
