<?php

namespace App\Actions\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface GetAllApplicantsActionInterface
{
    public function handler(User $user): Collection;
}
