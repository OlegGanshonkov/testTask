<?php

/** @var app\models\Book $book */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>




<?php

/** @var yii\web\View $this */

/** @var Book[] $books */

use app\models\Book;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12 mb-3">
                <h2>Просмотр книги</h2>
                <a href="/books" class="btn btn-primary">Каталог книг</a>

                <ul class="book-li">
                    <li>
                        <h3 style="display: inline-block; margin-right: 20px">
                            <?= Html::encode($book->name) ?>
                        </h3>
                        <?php
                        $form = ActiveForm::begin([
                            'action' => '/books/delete/' . $book->id,
                            'options' => [
                                'class' => 'book-form'
                            ]
                        ]) ?>
                        <?= Html::submitButton('Удалить книгу', ['class' => 'btn4 btn-danger', 'id' => 'save']) ?>
                        <?php ActiveForm::end() ?>
                    </li>
                    <li>Год выпуска: <?= $book->year ?></li>
                    <li>ISBN: <?= $book->isbn ?></li>
                    <li>
                        <p>
                            <img src="<?= '/uploads/'.$book->photo; ?>" class="book-photo" alt=""/>
                            <?= $book->description; ?>
                        </p>
                    </li>
                    <li style="clear: both">
                        <div>Авторы:</div>
                        <?php
                        $authors = $book->authors;
                        foreach ($authors as $key => $author) {
                            echo $author->last . ' ' . $author->first . ' ' . $author->middle;
                            ?>
                            <?php $form = ActiveForm::begin(['action' => '/books/subscribe']) ?>
                            <?= Html::hiddenInput('book_id', $book->id) ?>
                            <?= Html::hiddenInput('author_id', $author->id) ?>
                            <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
                            <?php ActiveForm::end() ?>
                            <?php
                            if (isset($authors[$key + 1])) {
                                echo ',<br/> ';
                            }
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
