<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Passport\PersonalAccessTokenResult;

class EloquentUserRepository implements UserRepositoryInterface
{
    private User $model;

    /**
     * EloquentUserRepository constructor.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function findByUsername(string $username): User
    {
        if (null == $model = $this->model->where('username', $username)->first()) {
            throw new ModelNotFoundException("User Not found with username: $username", 404);
        }

        return $model;
    }

    public function createToken(User|Authenticatable $user): PersonalAccessTokenResult
    {
        return $user->createToken('MY TOKEN');
    }
}
