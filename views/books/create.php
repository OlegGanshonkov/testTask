<?php

/* @var $book app\forms\BookForm */
/* @var $authors app\models\Author[] */


?>
<h5>Добавление книги</h5>
<a href="/books" class="btn btn-primary">Каталог книг</a>

<p>&nbsp;</p>
<?= $this->render('_form', compact('book', 'authors')); ?>

