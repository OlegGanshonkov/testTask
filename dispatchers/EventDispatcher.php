<?php

namespace app\dispatchers;

use app\dispatchers\interfaces\EventDispatcherInterface;
use app\models\User;
use yii\base\Component;

class EventDispatcher extends Component implements EventDispatcherInterface
{
    public $listeners = [];

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            $this->trigger($event->name, $event);
            \Yii::info(print_r($this->listeners, true) . 'Dispatch event ' . $event->name);
        }
    }

    public function addListener($eventName, $object, $methodName)
    {
        $this->listeners[] = \get_class($object);
        \Yii::info(print_r($this->listeners, true)  . 'Dispatch add listener ' . $eventName .  ' ' . $methodName);
        $this->on($eventName, [$object, $methodName]);
    }


}