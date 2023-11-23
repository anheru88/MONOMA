<?php

namespace App\Actions\Contracts;

use App\Exceptions\LoginException;
use App\Models\Applicant;

interface CreateApplicantActionInterface
{
    /**
     * @throws LoginException
     */
    public function handler(array $data): Applicant;
}
