<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Passport\PersonalAccessTokenResult;

interface UserRepositoryInterface
{
    /**
     * @throws ModelNotFoundException
     */
    public function findByUsername(string $username): User;

    public function createToken(User|Authenticatable $user): PersonalAccessTokenResult;
}
