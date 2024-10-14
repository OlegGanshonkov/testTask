<?php

namespace app\entities\Book;

use app\entities\Book\Book;
use app\entities\Book\Id;
use app\entities\Book\Isbn;
use app\entities\Book\Name;
use app\entities\Book\Year;
use app\entities\Book\Description;
use app\entities\Book\Photo;
use app\entities\Book\Author;
use Assert\AssertionFailedException;
use Faker\Generator;

class BookBuilder
{
    private Id $id;
    private Name $name;
    private Year $year;
    private Description $description;
    private Isbn $isbn;
    private Photo $photo;
    private array $authors = [];

    /**
     * @throws AssertionFailedException
     */
    public function __construct()
    {
        $this->id = Id::next();
        $this->name = new Name('PHP');
        $this->year = new Year(2024);
        $this->description = new Description('LOREM IPSUM');
        $this->isbn = new Isbn((new Generator())->isbn13());
        $this->photo = new Photo('sadasdasda.jpg');
        $this->authors = [
            new Author('Реджеп', 'Тайип', 'Эрдоган'),
            new Author('Мустафа', 'Кемаль', 'Ататюрк'),
        ];
    }

    public function withAuthors(array $authors): self
    {
        $clone = clone $this;
        $clone->authors = $authors;
        return $clone;
    }

    /**
     * @throws \Exception
     */
    public function build(): Book
    {
        $book = new Book(
            $this->id,
            $this->name,
            $this->year,
            $this->description,
            $this->isbn,
            $this->photo,
            $this->authors
        );

        return $book;
    }
}