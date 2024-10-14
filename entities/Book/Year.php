<?php

namespace app\entities\Book;

use Assert\Assertion;
use Assert\AssertionFailedException;
use DateTime;

class Year
{
    private string $year;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $year)
    {
        Assertion::date($year, 'Y');
        $this->year = $year;
    }

    public function getYear(): string
    {
        return $this->year;
    }

//    private function validateYear($year, $format = 'Y')
//    {
//        $d = DateTime::createFromFormat($format, $year);
//        return $d && strtolower($d->format($format)) === strtolower($year);
//    }
}