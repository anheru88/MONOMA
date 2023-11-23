<?php

namespace App\Actions\Contracts;

use App\Exceptions\LoginException;
use App\Models\Applicant;
use App\Models\User;

interface CreateApplicantActionInterface
{
    /**
     * @throws LoginException
     */
    public function handler(array $data, User $user): Applicant;
}
