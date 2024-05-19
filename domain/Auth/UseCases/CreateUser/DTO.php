<?php

declare(strict_types=1);

namespace Domain\Auth\UseCases\CreateUser;

class DTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ){}    
}