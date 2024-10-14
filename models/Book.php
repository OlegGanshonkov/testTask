<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * @property string name
 * @property int year
 * @property string description
 * @property string isbn
 * @property string photo
 */
class Book extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $uploadedFile;

    public static function tableName()
    {
        return 'book';
    }

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
            [['name', 'isbn'], 'unique'],
            [['name', 'year', 'isbn'], 'required'],
            [['year'], 'integer', 'min' => 1901, 'max' => 2155],
            [['name', 'description', 'isbn'], 'string'],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'photo' => 'Фото главной страницы',
            'authors' => 'Авторы',
        ];
    }

    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->via('bookAuthors');
    }

    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthors::class, ['book_id' => 'id']);
    }

    public function upload()
    {
        if ($this->validate() && $this->uploadedFile) {
            $this->uploadedFile->saveAs('uploads/' . $this->uploadedFile->baseName . '.' . $this->uploadedFile->extension);
            return true;
        } else {
            return false;
        }
    }

    private function getUploadPath()
    {
        return 'uploads/';
    }

    public function fileExists($file): bool
    {
        $file = $file ? $this->getUploadPath() . $file : null;
        return file_exists($file);
    }

    public function deletePhoto($photo)
    {
        if ($photo && $this->fileExists($photo)) {
            unlink($this->getUploadPath() . $photo);
        }
    }

}