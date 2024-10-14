<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int user_id
 * @property int author_id
 */
class AuthorSubscribers extends ActiveRecord
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
            [['author_id', 'user_id'], 'required'],
            [['author_id', 'user_id'], 'integer'],
        ];
    }

    public function deleteForUserId(int $user_id)
    {
        self::deleteAll(['user_id' => $user_id]);
    }

    public function deleteRow(int $user_id, int $author_id)
    {
        self::deleteAll(['user_id' => $user_id, 'author_id' => $author_id]);
    }

}