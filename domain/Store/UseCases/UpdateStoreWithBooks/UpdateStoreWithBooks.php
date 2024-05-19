<?php

declare(strict_types=1);

namespace Domain\Store\UseCases\UpdateStoreWithBooks;

use App\Models\Store;
use Domain\Book\Repositories\BookRepository;
use Domain\Store\Exceptions\NotFoundStoreException;
use Domain\Store\Repositories\StoreRepository;
use Illuminate\Support\Collection;

class UpdateStoreWithBooks
{
    public function __construct(
        private StoreRepository $repository,
        private BookRepository $bookRepository
    ){}

    public function execute(DTO $DTO): Store
    {
        if (!$this->repository->listStore($DTO->id)) {
            throw new NotFoundStoreException();
        }
        
        $books = new Collection();
        foreach ($DTO->bookIds as $bookid) {
            $book = $this->bookRepository->listBook($bookid);
            if ($book) {
                $books->push($book);
            }
        }

        $store = new Store();
        $store->id = $DTO->id;
        $store->name = $DTO->name;
        $store->address = $DTO->address;
        $store->active = $DTO->active;

        $storeSaved = $this->repository->updateStoreWithBooks($store, $books);

        return $storeSaved;
    }
}