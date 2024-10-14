<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int book_id
 * @property int author_id
 */
class BookAuthors extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()')
            ],
        ];
    }

    public function rules()
    {
        return [
            [['book_id', 'author_id'], 'required'],
            [['book_id', 'author_id'], 'integer'],
        ];
    }

    public function deleteForBookId(int $bookId)
    {
        self::deleteAll(['book_id' => $bookId]);
    }

}