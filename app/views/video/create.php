<?php
use TestWork\helpers\Html;
/**
 * @var \TestWork\models\Video $video
 * @var \TestWork\form\VideoForm $form
*/
?>

<a href="?r=video/index">back</a>

<?php if ($form->hasErrors()): ?>
    <div class="errors" style="border: 1px red solid;">
        <?php foreach ($form->getErrors() as $error):?>
            <div class="error"><?=Html::encode($error)?></div>
        <?php endforeach ?>
    </div>
<?php endif ?>

<form action="" method="post" enctype="multipart/form-data">
    <div>
        <label for="Video_title">Title</label>
        <input type="text" name="Video[title]" id="Video_title" value="<?=Html::encode($video->getTitle())?>"/>
    </div>

    <div>
        <label for="Video_original_title">Original Title</label>
        <input type="text" name="Video[original_title]" id="Video_original_title" value="<?=Html::encode($video->getOriginalTitle())?>"/>
    </div>

    <div>
        <label for="Video_country">Country</label>
        <input type="text" name="Video[country]" id="Video_country" value="<?=Html::encode($video->getCountry())?>"/>
    </div>

    <div>
        <label for="Video_image">Image</label>
        <input type="file" name="Video[image]" id="Video_image" />
    </div>

    <div>
        <label for="Video_genres_string">Genres</label>
        <input type="text" name="Video[genres_string]" id="Video_genres_string" value="<?=Html::encode($video->getGenresString())?>"/>
    </div>

    <div>
        <input type="submit" value="submit"/>
    </div>
</form>