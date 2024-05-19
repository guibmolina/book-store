<?php

declare(strict_types=1);

namespace Domain\Store\UseCases\CreateStoreWithBooks;

class DTO
{
    public function __construct(
        public string $name,
        public string $address,
        public bool $active,
        public array $bookIds
    ){}    
}