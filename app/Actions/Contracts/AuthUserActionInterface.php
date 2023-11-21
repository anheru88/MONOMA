<?php

namespace App\Actions\Contracts;

use App\Exceptions\LoginException;
use Laravel\Passport\PersonalAccessTokenResult;

interface AuthUserActionInterface
{
    /**
     * @throws LoginException
     */
    public function handler(array $data): PersonalAccessTokenResult;
}
