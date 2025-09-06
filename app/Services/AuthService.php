<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthService
{
    public function __construct(private AuthRepository $authRepo) {}

    /**
     * @param array $data
     *
     * @return array
     */
    public function register(array $data): array
    {
        $user = $this->authRepo->createUser([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return compact('user', 'token');
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function login(array $data): array
    {
        $user = $this->authRepo->findByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return compact('user', 'token');
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}
