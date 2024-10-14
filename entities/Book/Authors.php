<?php

namespace app\entities\Book;

class Authors
{
    /**
     * @var Author[]
     */
    private array $authors = [];

    public function __construct(array $authors)
    {
        if (!$authors) {
            throw new \Exception('Book must contain at least one Auhtor.');
        }
        foreach ($authors as $author) {
            $this->add($author);
        }
    }

    public function add(Author $author): void
    {
        foreach ($this->authors as $item) {
            if ($item->isEqualTo($author)) {
                throw new \Exception('Author already exists.');
            }
        }
        $this->authors[] = $author;
    }

    public function delete($authorId): Author
    {
        $authorIndex = array_search($authorId, array_column($this->authors, 'id'));
        $author = ($authorIndex !== false ? $this->authors[$authorIndex] : null);

        if (!$author) {
            throw new \Exception('Author is not found.');
        }
        if (\count($this->authors) === 1) {
            throw new \Exception('Cannot remove the last author.');
        }
        unset($this->authors[$authorIndex]);
        return $author;
    }

    public function getAll(): array
    {
        return $this->authors;
    }
}
