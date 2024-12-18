<?php

namespace App\Data;

use App\Models\Book;

/**
 * An example immutable Data Transfer Object (DTO) for Book
 *
 */
readonly class BookDTO
{

    public function __construct(
        public ?int $id = null,
        public string $title,
        public int $year,
        public float $rating,
        public int $category_id,

        public ?string $description = null,
        public ?string $image = null,

    ) {}



    /**
     * Return DTO as an array
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * Return a DTO from a Book object or array
     *
     * @param \App\Models\Book|array $book
     * @return BookDTO
     */
    public static function from(Book|array $book)
    {
        if (is_object($book)) {
            return new self(
                id: $book->id,
                title: (string) $book->title,
                year: $book->year,
                rating: $book->rating,
                category_id: $book->category_id,
                description: $book->description,
                image: $book->image,
            );
        }
        return new self(
            id: $book['id'] ?? null,
            title: $book['title'],
            year: $book['year'],
            rating: $book['rating'],
            category_id: $book['category_id'],
            description: $book['description'] ?? null,
            image: $book['image'] ?? null,
        );
    }
}
