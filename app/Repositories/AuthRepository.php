<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    /**
     * @param array $data
     *
     * @return User
     */
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
