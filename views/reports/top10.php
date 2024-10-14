<?php

/** @var yii\web\View $this */
/** @var array $data */

use app\models\Book;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\widgets\ListView;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12 mb-3">
                <h2>Отчет - ТОП 10 авторов выпуствиших больше книг за какой-то год.</h2>
                <a href="/books" class="btn btn-primary">Каталог книг</a>


                <p>&nbsp;</p>

                <?php
                $dataProvider = new SqlDataProvider([
                    'sql' => $data['sql'],
                    'totalCount' => $data['totalCount'],
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_top10_item',
                ]);

                ?>
            </div>
        </div>
    </div>
</div>
