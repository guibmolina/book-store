<?php

declare(strict_types=1);

namespace Infra\Store\Repositories;
use App\Models\Store;
use Domain\Store\Repositories\StoreRepository as StoreRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class StoreRepository implements StoreRepositoryInterface
{
    public function createStoreWithBooks(Store $store, Collection $books): Store
    {
        try {
            $store->save();
            $store->books()->sync($books->pluck("id")->toArray());
        } catch (Exception) {
            throw new Exception("Error to save store: {$store->name}");
        }

        return $store->fresh();
    }

    public function listStores(): Collection
    {
        try {
            $stores = Store::with('books')->get();
        } catch (Exception) {
            throw new Exception("Error to retrive stores");
        }
        return $stores;
    }

    public function listStore(int $id): ?Store
    {
        return Store::with('books')->find($id);
    }

    public function updateStoreWithBooks(Store $modifiedStore, Collection $books): Store
    {
        $store = Store::with('books')->find($modifiedStore->id);
        $store->name = $modifiedStore->name;
        $store->address = $modifiedStore->address;
        $store->active = $modifiedStore->active;

        try {
            $store->save();
            $store->books()->sync($books->pluck('id')->toArray());
        } catch (Exception $e) {
            throw new Exception("Error to update store $modifiedStore->id");
        }

        return $store->fresh()->load('books');
    }

    public function deleteStore(Store $store): void
    {
        try {
            $store->books()->detach();
            $store->delete();
        } catch (Exception) {
            throw new Exception("Error to delete store $store->id");
        }
    }
}