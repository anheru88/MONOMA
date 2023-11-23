<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface ApplicantRepositoryInterface
{

    /**
     * @param  array  $data
     * @return User
     */
    public function create(array $data): User;
}
