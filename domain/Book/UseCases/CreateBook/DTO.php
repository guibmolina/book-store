<?php

declare(strict_types=1);

namespace Domain\Book\UseCases\CreateBook;

class DTO
{
    public function __construct(
        public string $name,
        public int $ISNB,
        public float $value,
    ){}    
}