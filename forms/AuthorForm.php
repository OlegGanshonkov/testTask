<?php

namespace app\forms;

use app\models\Author;
use app\models\Book;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class BookForm
 * @package app\forms
 */
class AuthorForm extends Author
{
    public array $authors = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }

}
