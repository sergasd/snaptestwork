<?php
/**
 * @var \TestWork\models\Video[] $videos
 */
use TestWork\helpers\Html;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>videos list</title>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css"/>
</head>
<body>
    <div class="container">

        <a class="btn btn-default" href="?r=video/add">add video</a>
        <a class="btn btn-default" href="?r=genre/index">genres</a>


        <h1>Video list</h1>

        <?php foreach ($videos as $video): ?>
            <div class="video-list-item">
                <?= Html::encode($video->getTitle())?> <br/>
                <img src="<?= $video->getImageUrl('small')?>" alt="image"/> <br/>

                <a href="?r=video/edit&id=<?= Html::encode($video->getId())?>">edit</a>
                <a href="?r=video/delete&id=<?= Html::encode($video->getId())?>">delete</a>
            </div>
        <?php endforeach ?>

    </div>
</body>
</html>

