<?php

namespace app\entities\Book;

use app\entities\EventTrait;
use app\entities\interfaces\EntityInterface;
use Assert\Assertion;
use Assert\AssertionFailedException;

class Author implements EntityInterface
{

    private string $last;
    private string $first;
    private ?string $middle;
    public string $id;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $last, string $first, ?string $middle)
    {
        Assertion::notEmpty($last);
        Assertion::notEmpty($first);

        $this->last = $last;
        $this->first = $first;
        $this->middle = $middle;
        $this->id = 0;
    }

    public function isEqualTo(self $author): bool
    {
        return $this->getFull() === $author->getFull();
    }

    public function getFull(): string
    {
        return trim($this->last . ' ' . $this->first . ' ' . $this->middle);
    }

    public function getFirst(): string
    {
        return $this->first;
    }

    public function getMiddle(): ?string
    {
        return $this->middle;
    }

    public function getLast(): string
    {
        return $this->last;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getAttributes(): array
    {
        return [
            'last' => $this->last,
            'first' => $this->first,
            'middle' => $this->middle,
        ];
    }
}