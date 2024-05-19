<?php

declare(strict_types=1);

namespace Infra\Book\Repositories;
use App\Models\Book;
use Domain\Book\Repositories\BookRepository as BookRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{
    public function createBook(Book $book): Book
    {
        try {
            $book->save();
        } catch (Exception) {
            throw new Exception("Error to save book: {$book->name}");
        }

        return $book->fresh();
    }

    public function listBooks(): Collection
    {
        try {
            $books = Book::with('stores')->get();
        } catch (Exception) {
            throw new Exception("Error to retrive books");
        }
        return $books;
    }

    public function listBook(int $id): ?Book
    {
        return Book::with('stores')->find($id);
    }

    public function findBookByISNB(int $ISNB): ?Book
    {
        return Book::where("isnb", $ISNB)->first();
    }

    public function updateBook(Book $modifiedbook): Book
    {
        $book = Book::find($modifiedbook->id);
        $book->name = $modifiedbook->name;
        $book->ISNB = $modifiedbook->ISNB;
        $book->value = $modifiedbook->value;
        try {
            $book->save();
        } catch (Exception) {
            throw new Exception("Error to update book $modifiedbook->id");
        }

        return $book->fresh()->load('stores');
    }

    public function deleteBook(Book $book): void
    {
        try {
            $book->delete();
        } catch (Exception) {
            throw new Exception("Error to delete book $book->id");
        }
    }
}