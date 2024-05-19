<?php

declare(strict_types=1);

namespace Domain\Book\UseCases\UpdateBook;

class DTO
{
    public function __construct(
        public int $id,
        public string $name,
        public int $ISNB,
        public float $value,
    ){}    
}