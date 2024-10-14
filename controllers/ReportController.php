<?php

namespace app\controllers;

use app\dispatchers\EventDispatcher;
use app\entities\Book\Id;
use app\forms\BookForm;
use app\models\Author;
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

class ReportController extends Controller
{
    private $reportService;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['top10'],
                        'roles' => ['user', 'guest'],
                    ],
                ],
            ],
        ];
    }

    public function __construct($id, $module, ReportService $reportService, $config = [])
    {
        $this->reportService = $reportService;
        parent::__construct($id, $module, $config);
    }

    public function getViewPath()
    {
        return Yii::getAlias('@app/views/reports');
    }

    public function actionTop10()
    {
        $data = $this->reportService->top10();
        return $this->render('top10', compact('data'));
    }


}
