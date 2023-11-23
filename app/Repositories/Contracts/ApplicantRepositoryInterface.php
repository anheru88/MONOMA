<?php

namespace App\Repositories\Contracts;

use App\Models\Applicant;
use App\Models\User;

interface ApplicantRepositoryInterface
{
    public function create(array $data, User $user): Applicant;
}
