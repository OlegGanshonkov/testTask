<?php

namespace app\entities\Book;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Name
{
    private string $name;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $name)
    {
        Assertion::notEmpty($name);

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

}