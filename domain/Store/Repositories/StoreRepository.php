<?php

declare(strict_types=1);

namespace Domain\Store\Repositories;

use App\Models\Store;
use Illuminate\Support\Collection;

interface StoreRepository
{
    public function createStoreWithBooks(Store $entity, Collection $books): Store;

    public function listStores(): Collection;

    public function listStore(int $id): ?Store;

    public function updateStoreWithBooks(Store $store, Collection $books): Store;

    public function deleteStore(Store $store): void;
}