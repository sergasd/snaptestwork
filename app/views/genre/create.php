<?php
use TestWork\helpers\Html;
/**
 * @var \TestWork\models\Genre $genre
 * @var \TestWork\form\GenreForm $form
*/
?>

<a href="?r=genre/index">back</a>

<?php if ($form->hasErrors()): ?>
    <div>
        <?php foreach ($form->getErrors() as $error):?>
            <div class="error"><?=Html::encode($error)?></div>
        <?php endforeach ?>
    </div>
<?php endif ?>

<form action="" method="post">
    <div>
        <label for="Genre_name">Name</label>
        <input type="text" name="Genre[name]" id="Genre_name" value="<?=Html::encode($genre->getName())?>"/>
    </div>

    <div>
        <input type="submit" value="submit"/>
    </div>
</form>