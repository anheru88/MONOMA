<?php

namespace App\Http\Controllers\Api\Applicant;

use App\Actions\Contracts\GetAllApplicantsActionInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Applicant\GetAllApplicantsRequest;
use App\Http\Resources\ApplicantCollection;
use Symfony\Component\HttpFoundation\Response;

class GetAllApplicantsController extends Controller
{
    private GetAllApplicantsActionInterface $getAllApplicantsAction;

    public function __construct(GetAllApplicantsActionInterface $getAllApplicantsAction)
    {
        $this->getAllApplicantsAction = $getAllApplicantsAction;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(GetAllApplicantsRequest $request)
    {
        try {

            $applicants = $this->getAllApplicantsAction->handler(auth()->user());

            $response = [
                'meta' => [
                    'success' => true,
                    'errors'  => [],
                    'data'    => new ApplicantCollection($applicants),
                ],
            ];

            return response($response, Response::HTTP_OK);


        } catch (\Exception $exception) {
            $response = [
                'meta' => [
                    'success' => false,
                    'errors'  => [
                        $exception->getMessage(),
                    ],
                ],
            ];

            return response($response, $exception->getCode());
        }
    }
}
