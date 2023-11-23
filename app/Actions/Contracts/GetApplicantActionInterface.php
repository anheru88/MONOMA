<?php

namespace App\Actions\Contracts;

use App\Exceptions\LoginException;
use App\Models\Applicant;
use App\Models\User;

interface GetApplicantActionInterface
{
    /**
     * @throws LoginException
     */
    public function handler(int $id): Applicant;
}
