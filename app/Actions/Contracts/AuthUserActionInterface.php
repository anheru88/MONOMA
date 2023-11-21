<?php

namespace App\Actions\Contracts;

use App\Exceptions\LoginException;
use Laravel\Passport\PersonalAccessTokenResult;

interface AuthUserActionInterface
{
    /**
     * @param array $data
     * @throws LoginException
     * @return PersonalAccessTokenResult
     */
    public function handler(array $data): PersonalAccessTokenResult ;
}
