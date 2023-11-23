<?php

namespace App\Actions;

use App\Actions\Contracts\CreateApplicantActionInterface;
use App\Exceptions\LoginException;
use App\Models\Applicant;
use App\Repositories\Contracts\ApplicantRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Laravel\Passport\PersonalAccessTokenResult;
use Symfony\Component\HttpFoundation\Response;

class CreateApplicantAction implements CreateApplicantActionInterface
{
    private ApplicantRepositoryInterface $applicantRepository;

    public function __construct(ApplicantRepositoryInterface $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
    }

    public function handler(array $data): Applicant
    {
        return $this->applicantRepository->create($data);
    }
}
