<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Passport\PersonalAccessTokenResult;

interface UserRepositoryInterface
{

    /**
     * @param  string  $username
     * @throws ModelNotFoundException
     * @return User
     */
    public function findByUsername(string $username): User;

    /**
     * @param  Authenticatable|User  $user
     * @return PersonalAccessTokenResult
     */
    public function createToken(User|Authenticatable $user): PersonalAccessTokenResult ;
}
