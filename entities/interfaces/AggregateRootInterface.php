<?php

namespace app\entities\interfaces;

interface AggregateRootInterface
{
    /**
     * @return array
     */
    public function releaseEvents(): array;
}