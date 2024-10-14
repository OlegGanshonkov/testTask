<?php

namespace app\repositories;

use app\entities\Book\Author;
use app\entities\Book\Book;
use app\entities\Book\Description;
use app\entities\Book\Isbn;
use app\entities\Book\Name;
use app\entities\Book\Photo;
use app\entities\Book\Year;
use app\models\AuthorSubscribers;
use app\models\Book as BookModel;
use app\models\Author as AuthorModel;
use app\models\BookAuthors;
use app\entities\Book\Id;
use app\repositories\interfaces\AuthorRepositoryInterface;
use app\repositories\interfaces\BookRepositoryInterface;
use Assert\AssertionFailedException;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function subscribe(int $author_id, int $user_id): void
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            $authorSubscribers = AuthorSubscribers::findOne(['author_id' => $author_id, 'user_id' => $user_id]);
            if (!$authorSubscribers){
                $authorSubscribers = new AuthorSubscribers;
            }
            $authorSubscribers->author_id = $author_id;
            $authorSubscribers->user_id = $user_id;
            $authorSubscribers->save();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }


}