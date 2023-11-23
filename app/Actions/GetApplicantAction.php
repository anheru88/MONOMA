<?php

namespace App\Actions;

use App\Actions\Contracts\GetApplicantActionInterface;
use App\Models\Applicant;
use App\Repositories\Contracts\ApplicantRepositoryInterface;

class GetApplicantAction implements GetApplicantActionInterface
{
    private ApplicantRepositoryInterface $applicantRepository;

    public function __construct(ApplicantRepositoryInterface $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
    }

    public function handler(int $id): Applicant
    {
        return $this->applicantRepository->find($id);
    }
}
