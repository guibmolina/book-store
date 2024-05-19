<?php

declare(strict_types=1);

namespace Domain\Auth\UseCases\CreateUser;

use App\Models\User;
use Domain\Auth\Exceptions\UserAlreadyExistException;
use Domain\Auth\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function __construct(
        private AuthRepository $repository
    ){}

    public function execute(DTO $DTO): User
    {
        if ($this->repository->findUserByEmail($DTO->email)) {
            throw new UserAlreadyExistException();
        }

        $user = new User();
        $user->name = $DTO->name;
        $user->email = $DTO->email;
        $user->password = Hash::make($DTO->password);

        $userSaved = $this->repository->createUser($user);

        return $userSaved;
    }
}