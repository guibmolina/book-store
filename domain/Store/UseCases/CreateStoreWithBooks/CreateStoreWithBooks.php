<?php

declare(strict_types=1);

namespace Domain\Store\UseCases\CreateStoreWithBooks;

use App\Models\Store;
use Domain\Book\Repositories\BookRepository;
use Domain\Store\Repositories\StoreRepository;
use Illuminate\Support\Collection;

class CreateStoreWithBooks
{
    public function __construct(
        private StoreRepository $repository,
        private BookRepository $bookRepository
    ){}

    public function execute(DTO $DTO): Store
    {

        $store = new Store();
        $store->name = $DTO->name;
        $store->address = $DTO->address;
        $store->active = $DTO->active;

        $books = new Collection();
        foreach ($DTO->bookIds as $bookid) {
            $book = $this->bookRepository->listBook($bookid);
            if ($book) {
                $books->push($book);
            }
        }
        $storeSaved = $this->repository->createStoreWithBooks($store, $books);

        return $storeSaved;
    }
}