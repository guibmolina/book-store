<?php

declare(strict_types=1);

namespace Domain\Store\UseCases\GetStore;
use App\Models\Store;
use Domain\Store\Exceptions\NotFoundStoreException;
use Domain\Store\Repositories\StoreRepository;

class GetStore
{
    public function __construct(
        private StoreRepository $repository
    ){}

    public function execute(int $storeId): Store
    {
        $store = $this->repository->listStore($storeId);

        if (!$store) {
            throw new NotFoundStoreException();
        }
        return $store;
    }
}