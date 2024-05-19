<?php

declare(strict_types=1);

namespace Infra\Auth\Repositories;

use App\Models\User;
use Domain\Auth\Repositories\AuthRepository as RepositoriesAuthRepository;
use Exception;

class AuthRepository implements RepositoriesAuthRepository
{
   public function createUser(User $user): User
   {
        try {
            $user->save();
        } catch (Exception) {
            throw new Exception("Error to save user");
        }
        return $user->fresh();
   }

   public function createToken(User $user): string
   {
        return $user->createToken($user->email)->plainTextToken;
   }

   public function findUserByEmail(string $email): ?User
   {
        return User::where('email', $email)->first();
   }
}