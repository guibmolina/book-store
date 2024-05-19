<?php

declare(strict_types=1);

namespace Domain\Store\UseCases\UpdateStoreWithBooks;

class DTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
        public bool $active,
        public array $bookIds
    ){}    
}