<?php

namespace app\entities\Book;

use app\entities\EventTrait;
use app\entities\interfaces\AggregateRootInterface;
use app\entities\interfaces\EntityInterface;

class Book implements AggregateRootInterface, EntityInterface
{
    use EventTrait;

    private Id $id;
    private Name $name;
    private Year $year;
    private Description $description;
    private Isbn $isbn;
    private Photo $photo;
    private Authors $authors;

    /**
     * @throws \Exception
     */
    public function __construct(Id $id, Name $name, Year $year, Description $description, Isbn $isbn, Photo $photo, array $authors)
    {
        if (!$authors) {
            throw new \Exception('Book must contain at least one Author.');
        }
        $this->id = $id;
        $this->name = $name;
        $this->year = $year;
        $this->description = $description;
        $this->isbn = $isbn;
        $this->photo = $photo;
        $this->authors = new Authors($authors);
    }

    /**
     * @throws \Exception
     */
    public function update(Name $name, Year $year, Description $description, Isbn $isbn, Photo $photo, array $authors): void
    {
        $this->name = $name;
        $this->year = $year;
        $this->description = $description;
        $this->isbn = $isbn;
        $this->photo = $photo;
        $this->authors = new Authors($authors);
        $this->recordEvent(new Events\BookUpdated($this->id));
    }

    public function addAuthor(Author $author): void
    {
        $this->authors->add($author);
        $this->recordEvent(new Events\BookAuthorAdded($this->id, $author));
    }

    /**
     * @throws \Exception
     */
    public function deleteAuthor(string $authorId): void
    {
        $author = $this->authors->delete($authorId);
        $this->recordEvent(new Events\BookAuthorDeleted($this->id, $author));
    }

    public function delete(): void
    {
        $this->recordEvent(new Events\BookDeleted($this->id));
    }

    public function createEvent()
    {
        $this->recordEvent(new Events\BookCreated($this->id));
    }

    public function setId($id): void
    {
        $this->id = new Id($id);
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getYear(): Year
    {
        return $this->year;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getIsbn(): Isbn
    {
        return $this->isbn;
    }

    public function getPhoto(): Photo
    {
        return $this->photo;
    }

    public function getAuthors(): array
    {
        return $this->authors->getAll();
    }

    public function getAttributes(): array
    {
        return [
            'name' => $this->getName()->getName(),
            'year' => $this->getYear()->getYear(),
            'description' => $this->getDescription()->getDescription(),
            'isbn' => $this->getIsbn()->getIsbn(),
            'photo' => $this->getPhoto()->getPhoto(),
        ];
    }

}