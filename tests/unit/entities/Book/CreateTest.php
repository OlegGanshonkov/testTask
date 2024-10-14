<?php

namespace unit\entities\Book;


use app\entities\Book\Book;
use app\entities\Book\Id;
use app\entities\Book\Isbn;
use app\entities\Book\Name;
use app\entities\Book\Description;
use app\entities\Book\Photo;
use app\entities\Book\Author;
use app\entities\Book\Year;
use Codeception\Test\Unit;
use Faker\Generator;

class CreateTest extends Unit
{
    /**
     * @throws \Exception
     */
    public function testSuccess(): void
    {
        $book = new Book(
            $id = Id::next(),
            $name = new Name('PHP'),
            $year = new Year(2024),
            $description = new Description('LOREM IPSUM'),
            $isbn = new Isbn((new Generator())->isbn13()),
            $photo = new Photo('sadasdasda.jpg'),
            $authors = [
                new Author('Реджеп', 'Тайип', 'Эрдоган'),
                new Author('Мустафа', 'Кемаль', 'Ататюрк'),
            ]
        );

        $this->assertEquals($name, $book->getName());
        $this->assertEquals($year, $book->getYear());
        $this->assertEquals($description, $book->getDescription());
        $this->assertEquals($isbn, $book->getIsbn());
        $this->assertEquals($photo, $book->getPhoto());

        $this->assertNotNull($book->getName());
        $this->assertNotNull($book->getYear());
        $this->assertNotNull($book->getIsbn());
        $this->assertCount(2, $authors = $book->getAuthors());

    }

    public function testWithoutAuthor(): void
    {
        $this->expectExceptionMessage('Book must contain at least one Author.');

        new Book(
            Id::next(),
            new Name('PHP'),
            new Year(2024),
            new Description('LOREM IPSUM'),
            new Isbn((new Generator())->isbn13()),
            new Photo('sadasdasda.jpg'),
            []
        );
    }

    public function testWithSameAuthor(): void
    {
        $this->expectExceptionMessage('Author already exists.');

        new Book(
            Id::next(),
            new Name('PHP'),
            new Year(2024),
            new Description('LOREM IPSUM'),
            new Isbn((new Generator())->isbn13()),
            new Photo('sadasdasda.jpg'),
            [
                new Author('Реджеп', 'Тайип', 'Эрдоган'),
                new Author('Реджеп', 'Тайип', 'Эрдоган'),
            ]
        );
    }
}