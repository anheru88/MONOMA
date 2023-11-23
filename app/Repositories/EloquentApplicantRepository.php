<?php

namespace App\Repositories;

use App\Models\Applicant;
use App\Models\User;
use App\Repositories\Contracts\ApplicantRepositoryInterface;

class EloquentApplicantRepository implements ApplicantRepositoryInterface
{
    private Applicant $model;

    /**
     * EloquentUserRepository constructor.
     */
    public function __construct(Applicant $applicant)
    {
        $this->model = $applicant;
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }
}
