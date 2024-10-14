<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $book app\forms\BookForm */
/* @var $authors app\models\Author[] */
?>

<?php $form = ActiveForm::begin([]) ?>

<?= $form->field($book, 'name') ?>
<?= $form->field($book, 'year') ?>
<?= $form->field($book, 'description') ?>
<?= $form->field($book, 'isbn') ?>
<?= $form->field($book, 'photo')->fileInput() ?>

<div class="authors_wrap">
    <label class="control-label" for="authors[0][first]">Авторы</label>
    <ul class="full_name" style="list-style-type: circle ">
        <?php foreach ($authors as $index => $author): ?>
            <li>
                <?php
                echo $form->field($author, "[$index]last");
                echo $form->field($author, "[$index]first");
                echo $form->field($author, "[$index]middle");
                ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <div style="clear:both;">&nbsp;</div>

    <div class="more_authors">

    </div>

    <div>&nbsp;</div>
    <button id="addAuthor">+Добавить Автора</button>
</div>

<div>&nbsp;</div>
<?= Html::submitButton($book->id ? 'Обновить' : 'Сохранить', ['class' => 'btn4', 'id' => 'save']) ?>
<?php ActiveForm::end() ?>

<?php
$this->registerJs("
    (function($) {
        $('#addAuthor').click(function(e) {
            e.preventDefault();
            let count = $('.full_name li').length;
            let clone = $('.full_name').find('>li:first-child').clone();
            clone.find('input').val('');
            
            $.each(clone.find('div.form-group'), function(index, value){
                let item = $(value);
                
                let classFormGroup = item.attr('class');
                classFormGroup = classFormGroup.replace('author-0', 'author-'+count);
                item.attr('class', classFormGroup);
                
                let classControlLabel = item.find('.control-label').attr('for');
                classControlLabel = classControlLabel.replace('author-0', 'author-'+count);
                item.find('.control-label').attr('for', classControlLabel);
                
                let classFormControl = item.find('input.form-control').attr('id');
                classFormControl = classFormControl.replace('author-0', 'author-'+count);
                item.find('input.form-control').attr('id', classFormControl);
                
                let classFormControl2 = item.find('input.form-control').attr('name');
                classFormControl2 = classFormControl2.replace('Author[0', 'Author['+count);
                item.find('input.form-control').attr('name', classFormControl2);
            });
            
            $('.full_name').append(clone);
        });
    })( jQuery );", yii\web\View::POS_END);
?>
