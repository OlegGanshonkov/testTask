<?php

namespace app\repositories;

use app\entities\Book\Author;
use app\entities\Book\Book;
use app\entities\Book\Description;
use app\entities\Book\Isbn;
use app\entities\Book\Name;
use app\entities\Book\Photo;
use app\entities\Book\Year;
use app\models\Book as BookModel;
use app\models\Author as AuthorModel;
use app\models\BookAuthors;
use app\entities\Book\Id;
use app\repositories\interfaces\BookRepositoryInterface;
use Assert\AssertionFailedException;

class BookRepository implements BookRepositoryInterface
{
    /**
     * @throws AssertionFailedException
     */
    public function get(Id $id): Book
    {
        $bookModel = BookModel::findOne($id->getId());
        if (!$bookModel) {
            throw new \Exception('Book not found.');
        }

        extract(BookModel::find()->where(['id' => $id->getId()])->with('authors')->asArray()->one());

        $book = new Book(new Id($id), new Name($name), new Year($year), new Description($description), new Isbn($isbn), new Photo($photo),
            array_map(static function ($author) {
                $author = (object)$author;
                return new Author(
                    $author->last,
                    $author->first,
                    $author->middle
                );
            }, $authors));
        return $book;
    }

    public function add(Book $book): int
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $bookModel = new BookModel;
            $bookModel->load($book->getAttributes(), '');
            $bookModel->save();
            $bookModel->refresh();
            $bookId = $bookModel->id;

            $bookAuthors = new BookAuthors;
            $bookAuthors->deleteForBookId($bookId);
            foreach ($book->getAuthors() as $author) {
                $authorId = AuthorModel::getByAll($author->getLast(), $author->getFirst(), $author->getMiddle());
                if (!$authorId) {
                    $authorModel = new AuthorModel;
                    $authorModel->load($author->getAttributes(), '');
                    $authorModel->save();
                    $authorModel->refresh();
                    $authorId = $authorModel->id;
                }

                $bookAuthors = new BookAuthors;
                $bookAuthors->author_id = (int)$authorId;
                $bookAuthors->book_id = (int)$bookId;
                $bookAuthors->save();
            }

            $transaction->commit();
            return $bookId;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function save(Book $book): int
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $bookModel = BookModel::findOne($book->getId()->getId());
            $bookModel->load($book->getAttributes(), '');
            $bookModel->save();
            $bookId = $bookModel->id;

            $bookAuthors = new BookAuthors;
            $bookAuthors->deleteForBookId($bookId);
            foreach ($book->getAuthors() as $author) {
                $authorId = $author->getId();
                if (!$authorId) {
                    $authorId = AuthorModel::getByAll($author->getLast(), $author->getFirst(), $author->getMiddle());
                }
                $authorModel = $authorId ? AuthorModel::findOne($authorId) : new AuthorModel;
                $authorModel->load($author->getAttributes(), '');

                $authorModel->save();
                $authorModel->refresh();
                $authorId = $authorModel->id;

                $bookAuthors = new BookAuthors;
                $bookAuthors->author_id = (int)$authorId;
                $bookAuthors->book_id = (int)$bookId;
                $bookAuthors->save();
            }

            $transaction->commit();
            return $bookId;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function delete(Book $book): void
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $bookModel = BookModel::findOne($book->getId()->getId());
            $bookId = $bookModel->id;

            $bookAuthors = new BookAuthors;
            foreach ($book->getAuthors() as $author) {
                $authorId = AuthorModel::getByAll($author->getLast(), $author->getFirst(), $author->getMiddle());
                if ($authorId) {
                    $authorModel = AuthorModel::findOne($authorId);
                    $authorModel->delete();
                }
            }

            $bookAuthors->deleteForBookId($bookId);
            if ($bookModel->photo) {
                $bookModel->deletePhoto($bookModel->photo);
            }
            $bookModel->delete();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }


}