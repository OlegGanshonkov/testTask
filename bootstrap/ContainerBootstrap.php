<?php

namespace app\bootstrap;

use app\dispatchers\EventDispatcher;
use app\dispatchers\interfaces\EventDispatcherInterface;
use yii\base\BootstrapInterface;
use yii\di\Instance;

class ContainerBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(EventDispatcher::class);

    }
}
