<?php

namespace app\entities\Book\Events;

use app\entities\Book\Id;
use app\entities\Book\Author;
use yii\base\Event;

class BookAuthorAdded extends Event
{
    public Id $bookId;
    public Author $author;

    public function __construct(Id $bookId, Author $author)
    {
        $this->bookId = $bookId;
        $this->author = $author;
    }
}