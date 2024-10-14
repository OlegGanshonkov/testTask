<?php
namespace app\commands;

use Yii;
use yii\base\Exception;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $readBook = $auth->createPermission('readBook');
        $readBook->description = 'Read a book';
        $auth->add($readBook);

        $createBook = $auth->createPermission('createBook');
        $createBook->description = 'Create a book';
        $auth->add($createBook);

        $updateBook = $auth->createPermission('updateBook');
        $updateBook->description = 'Update book';
        $auth->add($updateBook);

        $deleteBook = $auth->createPermission('deleteBook');
        $deleteBook->description = 'Delete book';
        $auth->add($deleteBook);

        $bookSubscription = $auth->createPermission('bookSubscription');
        $bookSubscription->description = 'Book subscription';
        $auth->add($bookSubscription);

        $guest = $auth->createRole('guest');
        $auth->add($guest);
        $auth->addChild($guest, $readBook);
        $auth->addChild($guest, $bookSubscription);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createBook);
        $auth->addChild($user, $updateBook);
        $auth->addChild($user, $deleteBook);
        $auth->addChild($user, $guest);

        $auth->assign($guest, 2);
        $auth->assign($user, 1);
    }
}