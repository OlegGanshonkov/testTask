<?php

namespace app\entities\Book\Events;

use app\entities\Book\Id;
use app\entities\Book\Author;

class BookAuthorDeleted
{
    public Id $bookId;
    public Author $author;

    public function __construct(Id $bookId, Author $author)
    {
        $this->bookId = $bookId;
        $this->author = $author;
    }
}