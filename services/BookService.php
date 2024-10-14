<?php


namespace app\services;

use app\dispatchers\EventDispatcher;
use app\entities\Book\Author;
use app\entities\Book\Book;
use app\entities\Book\Description;
use app\entities\Book\Events\BookCreated;
use app\entities\Book\Id;
use app\entities\Book\Isbn;
use app\entities\Book\Name;
use app\entities\Book\Photo;
use app\entities\Book\Year;
use app\repositories\AuthorRepository;
use app\repositories\BookRepository;
use app\repositories\interfaces\AuthorRepositoryInterface;
use Assert\AssertionFailedException;

class BookService
{
    private BookRepository $bookRepository;
    private AuthorRepository $authorRepository;
    private $dispatcher;

    public function __construct(BookRepository $bookRepository, AuthorRepository $authorRepository, EventDispatcher $dispatcher)
    {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @throws AssertionFailedException
     * @throws \Exception
     */
    public function create(array $data): void
    {
        $data = (object)$data;
        $book = new Book(
            Id::next(),
            new Name($data->name),
            new Year($data->year),
            new Description($data->description),
            new Isbn($data->isbn),
            new Photo($data->photo),
            array_map(static function ($author) {
                $author = (object)$author;
                return new Author(
                    $author->last,
                    $author->first,
                    $author->middle ?? ''
                );
            }, $data->authors)
        );

        $book->setId($this->bookRepository->add($book));
        $book->createEvent();
        $this->dispatcher->dispatch($book->releaseEvents());
    }

    /**
     * @throws AssertionFailedException
     */
    public function update(Id $id, array $data): void
    {
        $data = (object)$data;
        $book = $this->bookRepository->get($id);
        $book->update(
            new Name($data->name),
            new Year($data->year),
            new Description($data->description),
            new Isbn($data->isbn),
            new Photo($data->photo),
            array_map(static function ($author) {
                $author = (object)$author;
                $res = new Author(
                    $author->last,
                    $author->first,
                    $author->middle ?? ''
                );
                if (isset($author->id)) { $res->setId($author->id); }
                return $res;
            }, $data->authors)
        );
        $book->setId($this->bookRepository->save($book));
        $this->dispatcher->dispatch($book->releaseEvents());
    }

    public function addAuthor(Id $id, $data): void
    {
        $data = (object)$data;

        $book = $this->bookRepository->get($id);
        $book->addAuthor(new Author(
            $data->last,
            $data->first,
            $data->middle ?? ''
        ));
        $this->bookRepository->save($book);
        $this->dispatcher->dispatch($book->releaseEvents());
    }

    /**
     * @throws \Exception
     */
    public function deleteAuthor(Id $id, $authorId): void
    {
        $book = $this->bookRepository->get($id);
        $book->deleteAuthor($authorId);
        $this->bookRepository->save($book);
        $this->dispatcher->dispatch($book->releaseEvents());
    }

    public function delete(Id $id): void
    {
        $book = $this->bookRepository->get($id);
        $book->delete();
        $this->bookRepository->delete($book);
        $this->dispatcher->dispatch($book->releaseEvents());
    }

    public function addSubscriber(int $author_id, int $user_id): void
    {
        $this->authorRepository->subscribe($author_id, $user_id);
    }
}