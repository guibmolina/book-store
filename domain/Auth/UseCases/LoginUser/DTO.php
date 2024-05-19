<?php

declare(strict_types=1);

namespace Domain\Auth\UseCases\LoginUser;

class DTO
{
    public function __construct(
        public string $email,
        public string $password,
    ){}    
}