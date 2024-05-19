<?php

declare(strict_types=1);

namespace Domain\Store\UseCases\GetStores;
use Domain\Store\Repositories\StoreRepository;
use Illuminate\Database\Eloquent\Collection;

class GetStores
{

    public function __construct(
        private StoreRepository $repository
    ){}

    public function execute(): Collection
    {
        $store = $this->repository->listStores();

        return $store;
    }
}