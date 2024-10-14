<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * @property string last
 * @property string first
 * @property string middle
 */
class Author extends ActiveRecord
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
            [['first', 'last'], 'required'],
            [['first', 'last', 'middle'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'last' => 'Фамилия',
            'first' => 'Имя',
            'middle' => 'Отчество',
        ];
    }

    public static function getAll()
    {
        return self::find()->select(['id', "CONCAT(first, ' ', last) AS full_name"])->all();
    }

    public static function getAllForWidget(): array
    {
        $authors = self::find()->select(['id', "CONCAT(first, ' ', last) AS full_name"])->all();
        $authors = ArrayHelper::map($authors, 'id', 'full_name');
        return $authors;
    }

    public static function getByAll(string $last, string $first, string $middle)
    {
        $author = self::findOne(['last' => $last, 'first' => $first, 'middle' => $middle]);
        return $author ? $author->id : null;
    }

}