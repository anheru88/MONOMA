<?php

namespace App\Actions\Contracts;

use App\Exceptions\LoginException;
use App\Models\Applicant;

interface GetApplicantActionInterface
{
    /**
     * @throws LoginException
     */
    public function handler(int $id): Applicant;
}
