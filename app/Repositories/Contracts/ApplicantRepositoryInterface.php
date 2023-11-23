<?php

namespace App\Repositories\Contracts;

use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ApplicantRepositoryInterface
{
    public function create(array $data, User $user): Applicant;

    /**
     * @throws ModelNotFoundException
     */
    public function find(int $id): Applicant;

    public function getAll();
}
