<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthLoginRequest;
use Domain\Auth\Exceptions\InvalidCredentialsException;
use Domain\Auth\Exceptions\UserAlreadyExistException;
use Domain\Auth\UseCases\CreateUser\CreateUser;
use Domain\Auth\UseCases\CreateUser\DTO;
use Domain\Auth\UseCases\LoginUser\DTO as LoginUserDTO;
use Domain\Auth\UseCases\LoginUser\LoginUser;
use Exception;
use Illuminate\Http\JsonResponse;
use Infra\Auth\Repositories\AuthRepository;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $DTO = new DTO(
            $request->name,
            $request->email,
            $request->password
        );

        $createUser = new CreateUser(new AuthRepository());
        $loginUser = new LoginUser(new AuthRepository());
        
       try {
           $createUser->execute($DTO);
           $loginUserDTO = new LoginUserDTO($request->email, $request->password);
           $token = $loginUser->execute($loginUserDTO);

        } catch (UserAlreadyExistException) {
            return response()->json(['message' => 'User Already Excist'], 422);
       } catch (Exception) {
            return response()->json(['message' => 'Server Error'], 500);
       }

        return response()->json([
            'token' => $token,
        ]);
    }

    public function login(AuthLoginRequest $request): JsonResponse
    {
        $loginUserDTO = new LoginUserDTO($request->email, $request->password);

        $loginUser = new LoginUser(new AuthRepository());
        
        try {
            $token = $loginUser->execute($loginUserDTO);
        } catch (InvalidCredentialsException) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        } catch (Exception) {
            return response()->json(['message' => 'Server Error'], 500);
        }

        return response()->json([
            'token' => $token,
        ]);
    }

    public function logout(): void
    {
        auth()->user()->tokens()->delete();
    }
}
