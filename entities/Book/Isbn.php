<?php

namespace app\entities\Book;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Isbn
{
    private string $isbn;

    /**
     * @param string $isbn
     */
    public function __construct(string $isbn)
    {

        if (!$this->findIsbn($isbn)) {
            throw new \InvalidArgumentException('No valid ISBN found.');
        }

        $this->isbn = $isbn;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    private function isValidIsbn10($isbn)
    {
        $check = 0;
        for ($i = 0; $i < 10; $i++) {
            if ('x' === strtolower($isbn[$i])) {
                $check += 10 * (10 - $i);
            } elseif (is_numeric($isbn[$i])) {
                $check += (int)$isbn[$i] * (10 - $i);
            } else {
                return false;
            }
        }
        return (0 === ($check % 11)) ? 1 : false;
    }

    private function findIsbn($str)
    {
        return true;
        $regex = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';
        if (preg_match($regex, str_replace('-', '', $str), $matches)) {
            return (10 === strlen($matches[1]))
                ? $this->isValidIsbn10($matches[1])
                : $this->isValidIsbn13($matches[1]);
        }
        return false;
    }

    private function isValidIsbn13($isbn)
    {
        $check = 0;

        for ($i = 0; $i < 13; $i += 2) {
            $check += (int)$isbn[$i];
        }

        for ($i = 1; $i < 12; $i += 2) {
            $check += 3 * $isbn[$i];
        }

        return (0 === ($check % 10)) ? 2 : false;
    }

}