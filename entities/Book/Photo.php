<?php

namespace app\entities\Book;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Photo
{
    private string $photo;

    public function __construct(string $photo)
    {

        $this->photo = $photo;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

}