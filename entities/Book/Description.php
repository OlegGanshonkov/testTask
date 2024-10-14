<?php

namespace app\entities\Book;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Description
{
    private string $description;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $description)
    {
        Assertion::notEmpty($description);

        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

}