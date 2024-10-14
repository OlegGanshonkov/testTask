<?php

namespace app\repositories\interfaces;

use app\entities\Book\Book;
use app\entities\Book\Id;

interface BookRepositoryInterface
{
    /**
     * @param Id $id
     * @return Book
     * @throws \Exception
     */
    public function get(Id $id): Book;

    public function add(Book $book): int;

    public function save(Book $book): int;

    public function delete(Book $book): void;

}