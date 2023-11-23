<?php

namespace App\Http\Requests\Api\Applicant;

use Illuminate\Foundation\Http\FormRequest;

class GetAllApplicantsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }
}
