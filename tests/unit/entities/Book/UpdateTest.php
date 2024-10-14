<?php

namespace unit\entities\Book;


use app\entities\Book\BookBuilder;
use app\entities\Book\Isbn;
use app\entities\Book\Name;
use app\entities\Book\Description;
use app\entities\Book\Photo;
use app\entities\Book\Year;
use Codeception\Test\Unit;
use Faker\Generator;
use app\entities\Book\Author;

class UpdateTest extends Unit
{
    public function testSuccess(): void
    {
        $book = (new BookBuilder())->build();
        $book->update(
            $name = new Name('PHP2'),
            $year = new Year(2023),
            $description = new Description('LOREM IPSUM2'),
            $isbn = new Isbn((new Generator())->isbn13()),
            $photo = new Photo('sadasdasda2.jpg'),
            $authors = [
                new Author('Реджеп2', 'Тайип2', 'Эрдоган2'),
                new Author('Мустафа2', 'Кемаль2', 'Ататюрк2'),
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

}