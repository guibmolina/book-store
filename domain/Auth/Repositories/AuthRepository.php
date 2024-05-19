<?php

declare(strict_types=1);

namespace Domain\Auth\Repositories;

use App\Models\User;

interface AuthRepository
{
    public function createUser(User $entity): User;

    public function createToken(User $user): string;

    public function findUserByEmail(string $email): ?User;
}