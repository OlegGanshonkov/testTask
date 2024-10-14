<?php

/** @var app\models\Book $model */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="book">
    <ul class="book-li">
        <li>
            (<b><?= $model['count']; ?></b>) <?= $model['full_name'] ?>
        </li>
    </ul>
</div>