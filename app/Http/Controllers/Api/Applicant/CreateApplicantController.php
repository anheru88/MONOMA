<?php

namespace App\Http\Controllers\Api\Applicant;

use App\Actions\Contracts\CreateApplicantActionInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Applicant\CreateRequest;
use App\Http\Resources\ApplicantResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CreateApplicantController extends Controller
{
    private CreateApplicantActionInterface $createApplicantAction;

    public function __construct(CreateApplicantActionInterface $createApplicantAction)
    {
        $this->createApplicantAction = $createApplicantAction;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request)
    {
        $applicant = $this->createApplicantAction->handler($request->all(), Auth::user());

        $response = [
            'meta' => [
                'success' => true,
                'errors' => [],
                'data' => [
                    new ApplicantResource($applicant),
                ],
            ],
        ];

        return response($response, Response::HTTP_OK);
    }
}
