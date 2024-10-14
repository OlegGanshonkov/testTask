<?php

namespace app\jobs;

use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;

/**
 * Отправляем данные в АПИ логгера
 * Class LogJob
 * @package app\job
 */
class NotificationJob extends BaseObject implements \yii\queue\JobInterface
{
    public $userIds;
    public $author_id;

    public function execute($queue)
    {
        \Yii::info('NotificationJob started ');

        \Yii::info('NotificationJob started '. print_r($this->userIds, true) . ' ' . print_r($this->author_id, true));

        foreach ($this->userIds as $userId) {
            $user = \app\models\User::findOne($userId);

            $apiId = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';
            $api = new \yiidreamteam\smspilot\Api($apiId);
            $result= $api->send('79112223344', 'New Book Added');
            \Yii::info('sms: ' . print_r($result, true));
        }
    }
}