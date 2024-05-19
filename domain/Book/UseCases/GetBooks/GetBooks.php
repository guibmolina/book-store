<?php

declare(strict_types=1);

namespace Domain\Book\UseCases\GetBooks;
use Domain\Book\Repositories\BookRepository;
use Illuminate\Database\Eloquent\Collection;

class GetBooks
{

    public function __construct(
        private BookRepository $repository
    ){}

    public function execute(): Collection
    {
        $books = $this->repository->listBooks();

        return $books;
    }
}