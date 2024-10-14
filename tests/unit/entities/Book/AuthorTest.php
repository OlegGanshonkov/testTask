<?php

namespace unit\entities\Book;

use app\entities\Book\BookBuilder;
use app\entities\Book\Events\BookAuthorAdded;
use app\entities\Book\Events\BookAuthorDeleted;
use app\entities\Book\Id;
use app\entities\Book\Name;
use app\entities\Book\Description;
use app\entities\Book\Photo;
use app\entities\Book\Author;
use app\models\ContactForm;
use Codeception\Test\Unit;
use Faker\Calculator\Isbn;
use Faker\Generator;
use unit\entities\Book\CreateTest;

class AuthorTest extends Unit
{
    /**
     * @throws \Exception
     */
    public function testAdd(): void
    {
        $book = (new BookBuilder())->build();

        $book->addAuthor($author = new Author('Сулейман', 'Демирель', 'Cо'));

        $this->assertNotEmpty($authors = $book->getAuthors());
        $this->assertEquals($author, end($authors));

        $this->assertNotEmpty($events = $book->releaseEvents());
        $this->assertInstanceOf(BookAuthorAdded::class, end($events));
    }

    public function testAddExists(): void
    {
        $book = (new BookBuilder())
            ->withAuthors([$author = new Author('Реджеп', 'Тайип', 'Эрдоган')])
            ->build();

        $this->expectExceptionMessage('Author already exists.');

        $book->addAuthor($author);
    }

    public function testDelete(): void
    {
        $book = (new BookBuilder())->build();

        $this->assertCount(2, $book->getAuthors());

        $authors = $book->getAuthors();
        $authorFirst = array_shift($authors);
        $book->deleteAuthor($authorFirst->getId());

        $this->assertCount(1, $book->getAuthors());

        $this->assertNotEmpty($events = $book->releaseEvents());
        $this->assertInstanceOf(BookAuthorDeleted::class, end($events));
    }

    /**
     * @throws \Exception
     */
    public function testDeleteNotExists(): void
    {
        $book = (new BookBuilder())->build();

        $this->expectExceptionMessage('Author is not found.');

        $book->deleteAuthor(9999);
    }

    /**
     * @throws \Exception
     */
    public function testDeleteLast(): void
    {
        $author = new Author('Сулейман', 'Демирель', 'Cо');
        $book = (new BookBuilder())
            ->withAuthors([$author])
            ->build();

        $this->expectExceptionMessage('Cannot remove the last author.');

        $book->deleteAuthor($author->getId());
    }

}