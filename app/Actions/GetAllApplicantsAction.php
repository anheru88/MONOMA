<?php

namespace App\Actions;

use App\Actions\Contracts\GetAllApplicantsActionInterface;
use App\Models\User;
use App\Repositories\Contracts\ApplicantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetAllApplicantsAction implements GetAllApplicantsActionInterface
{
    private ApplicantRepositoryInterface $applicantRepository;

    public function __construct(ApplicantRepositoryInterface $applicantRepository)
    {
        $this->applicantRepository = $applicantRepository;
    }

    public function handler(User $user): Collection
    {
        if ($user->role === 'manager') {
            return $this->applicantRepository->getAll();
        }

        return $this->applicantRepository->getAll($user->id);
    }
}
