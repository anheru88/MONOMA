<?php

namespace App\Actions;

use App\Actions\Contracts\CreateApplicantActionInterface;
use App\Models\Applicant;
use App\Models\User;
use App\Repositories\Contracts\ApplicantRepositoryInterface;

class CreateApplicantAction implements CreateApplicantActionInterface
{
    private ApplicantRepositoryInterface $applicantRepository;

    public function __construct(ApplicantRepositoryInterface $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
    }

    public function handler(array $data, User $user): Applicant
    {
        return $this->applicantRepository->create($data, $user);
    }
}
