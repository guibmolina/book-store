<?php

declare(strict_types=1);

namespace Domain\Auth\UseCases\LoginUser;

use Domain\Auth\Exceptions\InvalidCredentialsException;
use Domain\Auth\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;

class LoginUser
{
    public function __construct(
        private AuthRepository $repository
    ){}

    public function execute(DTO $DTO): string
    {
        $user = $this->repository->findUserByEmail($DTO->email);

        if (!$user) {
            throw new InvalidCredentialsException();
        }

        if (!Hash::check($DTO->password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        $user->tokens()->delete();

        $token = $this->repository->createToken($user) ;

        return $token;
    }
}