<?php

declare(strict_types=1);

namespace Domain\Book\UseCases\GetBook;
use App\Models\Book;
use Domain\Book\Exceptions\NotFoundBookException;
use Domain\Book\Repositories\BookRepository;

class GetBook
{
    public function __construct(
        private BookRepository $repository
    ){}

    public function execute(int $bookId): Book
    {
        $book = $this->repository->listBook($bookId);

        if (!$book) {
            throw new NotFoundBookException();
        }
        return $book;
    }
}