<?php

namespace App\Http\Controllers\Api\Applicant;

use App\Actions\Contracts\GetApplicantActionInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicantResource;
use Symfony\Component\HttpFoundation\Response;

class GetApplicantController extends Controller
{
    private GetApplicantActionInterface $getApplicantAction;

    /**
     * @param  GetApplicantActionInterface  $getApplicantAction
     */
    public function __construct(GetApplicantActionInterface $getApplicantAction)
    {
        $this->getApplicantAction = $getApplicantAction;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(int $id)
    {
        try {
            $applicant = $this->getApplicantAction->handler($id);

            $response = [
                'meta' => [
                    'success' => true,
                    'errors'  => [],
                    'data'    => [
                        new ApplicantResource($applicant),
                    ],
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
