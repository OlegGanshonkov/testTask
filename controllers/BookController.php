<?php

namespace app\controllers;

use app\dispatchers\EventDispatcher;
use app\entities\Book\Id;
use app\forms\BookForm;
use app\models\Author;
use app\models\AuthorSubscribers;
use app\models\Book;
use app\models\User;
use app\services\ReportService;
use app\services\BookService;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class BookController extends Controller
{
    private $bookService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['user', 'guest'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['user', 'guest'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['user'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['user'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['user'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['report'],
                        'roles' => ['user'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['subscribe'],
                        'roles' => ['user', 'guest'],
                    ],
                ],
            ],
        ];
    }

    public function __construct($id, $module, BookService $bookService, $config = [])
    {
        $this->bookService = $bookService;
        parent::__construct($id, $module, $config);
    }

    public function getViewPath()
    {
        return Yii::getAlias('@app/views/books');
    }

    public function actionIndex()
    {
        $books = Book::find();
        return $this->render('index', compact('books'));
    }

    public function actionCreate()
    {
        $book = new BookForm();
        $book->load(\Yii::$app->request->post());

        $countAuthors = count(Yii::$app->request->post('Author', []));
        $authors = [new Author()];
        for ($i = 1; $i < $countAuthors; $i++) {
            $authors[] = new Author();
        }

        if ($book->validate() && Model::loadMultiple($authors, Yii::$app->request->post('Author'), '') && Model::validateMultiple($authors)) {
            $book->uploadedFile = UploadedFile::getInstance($book, 'photo');
            if ($book->upload()) {
                $book->photo = $book->uploadedFile->fullPath;
            }
            $data = $book->toArray();
            $data['authors'] = ArrayHelper::toArray($authors);
            try {
                $this->bookService->create($data);
                Yii::$app->session->setFlash('success', 'Книга успешно добавлена!');
                return $this->redirect(['books/index']);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage().$e->getTraceAsString());
            }
        }

        return $this->render('create', [
            'book' => $book,
            'authors' => $authors,
        ]);
    }

    public function actionUpdate($id)
    {
        $book = BookForm::findOne($id);
        $book->load(\Yii::$app->request->post());

        $authors = $book->authors;

        $countAuthors = count(Yii::$app->request->post('Author', [])) - count($authors);
        for ($i = 1; $i <= $countAuthors; $i++) {
            $authors[] = new Author();
        }

        if ($book->validate() && Model::loadMultiple($authors, Yii::$app->request->post('Author'), '') && Model::validateMultiple($authors)) {
            $book->uploadedFile = UploadedFile::getInstance($book, 'photo');
            if ($book->upload()) {
                $book->photo = $book->uploadedFile->fullPath;
            }
            $data = $book->toArray();
            $data['authors'] = ArrayHelper::toArray($authors);

            try {
                $this->bookService->update((new Id($book->id)), $data);
                Yii::$app->session->setFlash('success', 'Книга успешно обновлена!');
                return $this->redirect(['books/index']);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'book' => $book,
            'authors' => $authors,
        ]);
    }

    public function actionView($id)
    {
        $book = BookForm::findOne($id);
        return $this->render('view', compact('book'));
    }

    public function actionDelete($id)
    {
        $book = BookForm::findOne($id);

        if ($book) {
            try {
                $this->bookService->delete(new Id($book->id));
                Yii::$app->session->setFlash('success', 'Книга успешно удалена!');
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->redirect(['books/index']);
    }

    public function actionSubscribe()
    {
        $bookId = Yii::$app->request->post('book_id');
        $userId = Yii::$app->user->id;

        $authorSubscriber = new AuthorSubscribers();
        $authorSubscriber->load(array_merge(\Yii::$app->request->post(), ['user_id' => $userId]), '');

        if ($authorSubscriber->validate()) {
            try {
                $this->bookService->addSubscriber($authorSubscriber->author_id, $authorSubscriber->user_id);
                Yii::$app->session->setFlash('success', 'Вы успешно подписались!');
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(['books/view/' . $bookId]);
    }

}
