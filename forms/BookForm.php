<?php

namespace app\forms;

use app\models\Book;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class BookForm
 * @package app\forms
 */
class BookForm extends Book
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }

}
