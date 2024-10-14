<?php

/** @var app\models\Book $model */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="book">

    <ul class="book-li">
        <li>
            <h3 style="display: inline-block; margin-right: 20px">
                <a href="/books/view/<?= $model->id; ?>"><?= Html::encode($model->name) ?></a>
            </h3>
            <a href="/books/update/<?= $model->id; ?>" class="btn btn-primary">Изменить книгу</a>
        </li>
        <li>Год выпуска: <?= $model->year ?></li>
        <li>ISBN: <?= $model->isbn ?></li>
        <li>
            <p>
                <img src="<?= '/uploads/'.$model->photo; ?>" class="book-photo"  alt=""/>
                <?= $model->description; ?>
                <div>Авторы:</div>
                <?php
                $authors = $model->authors;
                foreach ($authors as $key => $author) {
                    echo $author->last . ' ' . $author->first . ' ' . $author->middle;
                    if (isset($authors[$key+1])) {
                        echo ',<br/> ';
                    }
                }
                ?>
            </p>
        </li>
    </ul>

</div>