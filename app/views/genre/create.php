<?php
use TestWork\helpers\Html;
/**
 * @var \TestWork\models\Genre $genre
 * @var \TestWork\form\GenreForm $form
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
        <a class="btn btn-default" href="?r=genre/index">back</a>

        <?php if ($form->hasErrors()): ?>
            <div class="bg-danger">
                <?php foreach ($form->getErrors() as $error):?>
                    <div class="error"><?=Html::encode($error)?></div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <h1>Genre form</h1>

        <form action="" method="post" role="form">
            <div class="form-group">
                <label for="Genre_name">Name</label>
                <input class="form-control" type="text" name="Genre[name]" id="Genre_name" value="<?=Html::encode($genre->getName())?>"/>
            </div>

            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="submit"/>
            </div>
        </form>

    </div>
</body>
</html>
