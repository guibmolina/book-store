<?php

declare(strict_types=1);

namespace Domain\Book\UseCases\CreateBook;

use App\Models\Book;
use Domain\Book\Exceptions\BookISNBAlreadyExistException;
use Domain\Book\Repositories\BookRepository;

class CreateBook
{
    public function __construct(
        private BookRepository $repository
    ){}

    public function execute(DTO $DTO): Book
    {
        if ($this->repository->findBookByISNB($DTO->ISNB)) {
            throw new BookISNBAlreadyExistException();
        }

        $book = new Book();
        $book->name = $DTO->name;
        $book->ISNB = $DTO->ISNB;
        $book->value = $DTO->value;

        $bookSaved = $this->repository->createBook($book);

        return $bookSaved;
    }
}