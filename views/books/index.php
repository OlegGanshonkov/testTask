<?php

/** @var yii\web\View $this */
/** @var Book[] $books */

use app\models\Book;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12 mb-3">
                <h2>Каталог книг</h2>
                <a href="/books/create" class="btn btn-primary">Добавить книгу</a>
                <a href="/report/top10" class="btn btn-primary">Отчет</a>

                <p>&nbsp;</p>

                <?php
                $dataProvider = new ActiveDataProvider([
                    'query' => $books,
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_index_item',
                ]);

                ?>
            </div>
        </div>
    </div>
</div>
