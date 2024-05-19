<?php

declare(strict_types=1);

namespace Domain\Store\UseCases\DeleteStore;
use Domain\Store\Exceptions\NotFoundStoreException;
use Domain\Store\Repositories\StoreRepository;

class DeleteStore
{

    public function __construct(
        private StoreRepository $repository
    ){}

    public function execute(int $storeId): void
    {
        $store = $this->repository->listStore($storeId);

        if (!$store) {
            throw new NotFoundStoreException();
        }

        $this->repository->deleteStore($store);
    }
}