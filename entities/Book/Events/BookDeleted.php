<?php

namespace app\entities\Book\Events;

use app\entities\Book\Id;
use app\entities\Book\Author;
use yii\base\Event;

class BookDeleted extends Event
{
    public $name = 'Book Deleted';

    public Id $bookId;

    public function __construct(Id $bookId)
    {
        parent::__construct();
        $this->bookId = $bookId;
    }
}