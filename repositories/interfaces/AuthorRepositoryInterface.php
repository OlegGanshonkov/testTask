<?php

namespace app\repositories\interfaces;

use app\entities\Book\Book;
use app\entities\Book\Id;

interface AuthorRepositoryInterface
{
    /**
     * @param int $id
     * @throws \Exception
     */
    public function subscribe(int $author_id, int $user_id): void;

}