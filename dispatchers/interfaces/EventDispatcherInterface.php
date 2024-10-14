<?php

namespace app\dispatchers\interfaces;

interface EventDispatcherInterface
{
    public function dispatch(array $events): void;
}