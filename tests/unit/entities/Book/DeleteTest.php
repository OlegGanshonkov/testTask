<?php

namespace unit\entities\Book;


use app\entities\Book\BookBuilder;
use app\entities\Book\Events\BookDeleted;
use Codeception\Test\Unit;

class DeleteTest extends Unit
{
    public function testSuccess(): void
    {
        $book = (new BookBuilder())->build();

        $book->delete();

        $this->assertNotEmpty($events = $book->releaseEvents());
        $this->assertInstanceOf(BookDeleted::class, end($events));
    }

}