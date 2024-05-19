<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use Domain\Store\Exceptions\NotFoundStoreException;
use Domain\Store\UseCases\CreateStoreWithBooks\CreateStoreWithBooks;
use Domain\Store\UseCases\CreateStoreWithBooks\DTO;
use Exception;
use Domain\Store\UseCases\DeleteStore\DeleteStore;
use Domain\Store\UseCases\GetStore\GetStore;
use Domain\Store\UseCases\GetStores\GetStores;
use Domain\Store\UseCases\UpdateStoreWithBooks\DTO as UpdateStoreWithBooksDTO;
use Domain\Store\UseCases\UpdateStoreWithBooks\UpdateStoreWithBooks;
use Illuminate\Http\JsonResponse;
use Infra\Book\Repositories\BookRepository;
use Infra\Store\Repositories\StoreRepository;

class StoreController extends Controller
{
    public function index(): JsonResponse
    {
        $getStore = new GetStores(new StoreRepository());

        try {
            $stores = $getStore->execute();
        } catch (Exception) {
            return response()->json(['message' => 'Server Error'], 500);
        }

        return response()->json(['data' => $stores]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $DTO = new DTO(
            $request->name,
            $request->address,
            $request->active,
            $request->book_ids ?? []
        );

        $createStore = new CreateStoreWithBooks(
            new StoreRepository(),
            new BookRepository(),
        );

        try {
            $store = $createStore->execute($DTO);
        } catch (Exception) {
            return response()->json(['message' => 'Server Error'], 500);
        }

        return response()->json(['data' => $store]);
    }

    public function update(int $storeId, StoreRequest $request): JsonResponse
    {
        $DTO = new UpdateStoreWithBooksDTO(
            $storeId,
            $request->name,
            $request->address,
            $request->active,
            $request->book_ids ?? []
        );

        $updateStore = new UpdateStoreWithBooks(
            new StoreRepository(),
            new BookRepository(),
        );

        try {
           $store = $updateStore->execute($DTO);
        } catch (NotFoundStoreException $e) {
            return response()->json([], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Server Error'], 500);
        }
        return response()->json(['data' => $store]);
    }

    public function show(int $storeId): JsonResponse
    {
        $getStore = new GetStore(new StoreRepository());

        try {
            $store = $getStore->execute($storeId);
        } catch (NotFoundStoreException) {
            return response()->json([], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Server Error'], 500);
        }

        return response()->json(['data' => $store]);
    }

    public function destroy(int $storeId): JsonResponse
    {
        $deleteSotre = new DeleteStore(new StoreRepository());

        try {
            $deleteSotre->execute($storeId);
        } catch (NotFoundStoreException) {
            return response()->json([], 404);
        } catch (Exception) {
            return response()->json(['message' => 'Server Error'], 500);
        }

        return  response()->json([], 204);
    }
}
