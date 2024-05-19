<?php

declare(strict_types=1);

namespace Domain\Book\UseCases\DeleteBook;

use Domain\Book\Exceptions\NotFoundBookException;
use Domain\Book\Repositories\BookRepository;

class DeleteBook
{

    public function __construct(
        private BookRepository $repository
    ){}

    public function execute(int $bookId): void
    {
        $book = $this->repository->listBook($bookId);

        if (!$book) {
            throw new NotFoundBookException();
        }

        $this->repository->deleteBook($book);
    }
}