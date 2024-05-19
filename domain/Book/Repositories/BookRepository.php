<?php

declare(strict_types=1);

namespace Domain\Book\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

interface BookRepository
{
    public function createBook(Book $entity): Book;

    public function listBooks(): Collection;

    public function listBook(int $id): ?Book;

    public function findBookByISNB(int $ISNB): ?Book;

    public function updateBook(Book $book): Book;

    public function deleteBook(Book $book): void;
}