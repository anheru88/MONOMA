<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Passport\PersonalAccessTokenResult;

class EloquentUserRepository implements UserRepositoryInterface
{

    /**
     * @var User
     */
    private User $model;

    /**
     * EloquentUserRepository constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param  string  $username
     * @return User
     * @throws ModelNotFoundException
     */
    public function findByUsername(string $username): User
    {
        if (null == $model = $this->model->where('username', $username)->first()) {
            throw new ModelNotFoundException("User Not found with username: $username", 404);
        }

        return $model;
    }

    /**
     * @param  User|Authenticatable  $user
     * @return PersonalAccessTokenResult
     */
    public function createToken(User|Authenticatable $user): PersonalAccessTokenResult
    {
        return $user->createToken('MY TOKEN');
    }


}
