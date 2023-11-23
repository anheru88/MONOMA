<?php

namespace App\Repositories\Contracts;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ApplicantRepositoryInterface
{

    /**
     * @param  array  $data
     * @param  User  $user
     * @return Applicant
     */
    public function create(array $data, User $user): Applicant;

    /**
     * @param  int  $id
     * @return Applicant
     * @throws ModelNotFoundException
     */
    public function find(int $id): Applicant;
}
