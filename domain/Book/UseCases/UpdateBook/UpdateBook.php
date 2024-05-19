<?php

declare(strict_types=1);

namespace Domain\Book\UseCases\UpdateBook;

use App\Models\Book;
use Domain\Book\Exceptions\BookISNBAlreadyExistException;
use Domain\Book\Exceptions\NotFoundBookException;
use Domain\Book\Repositories\BookRepository;

class UpdateBook
{
    public function __construct(
        private BookRepository $repository
    ){}

    public function execute(DTO $DTO): Book
    {
        if (!$this->repository->listBook($DTO->id)) {
            throw new NotFoundBookException();
        }

        $bookStored = $this->repository->findBookByISNB($DTO->ISNB);

        if ($bookStored && $bookStored->id !== $DTO->id) {
            throw new BookISNBAlreadyExistException();
        }
    
        $book = new Book();
        $book->id = $DTO->id;
        $book->name = $DTO->name;
        $book->ISNB = $DTO->ISNB;
        $book->value = $DTO->value;

        $bookSaved = $this->repository->updateBook($book);

        return $bookSaved;
    }
}