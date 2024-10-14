<?php

namespace app\entities\Book\Events;

use app\entities\Book\Id;
use yii\base\Event;

class BookCreated extends Event
{
    public $name = 'Book Created';
    public Id $bookId;

    public function __construct(Id $bookId)
    {
        parent::__construct();
        $this->bookId = $bookId;
    }

}