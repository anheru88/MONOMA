<?php

namespace App\Repositories;

use App\Models\Applicant;
use App\Models\User;
use App\Repositories\Contracts\ApplicantRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function create(array $data, User $user): Applicant
    {
        $data['created_by'] = $user->id;

        return $this->model->create($data);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function find(int $id): Applicant
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('No lead found', 404);
        }
    }

    public function getAll(int $owner = null)
    {
        if (is_null($owner)) {
            return $this->model->all();
        }

        return $this->model->where('owner', $owner)->get();
    }
}
