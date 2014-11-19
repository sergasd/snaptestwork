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
</head>
<body>

    <div class="content">

        <a href="?r=video/add">add video</a> <br/>
        <a href="?r=genre/index">genres</a> <br/>


        <br/> <br/>

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

