<?php

namespace App\Http\Controllers\Api;

use App\Actions\Contracts\AuthUserActionInterface;
use App\Exceptions\LoginException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private AuthUserActionInterface $authUserAction;

    /**
     * @param  AuthUserActionInterface  $authUserAction
     */
    public function __construct(AuthUserActionInterface $authUserAction)
    {
        $this->authUserAction = $authUserAction;
    }

    /**
     * Handle the incoming request.
     * @throws LoginException
     */
    public function __invoke(AuthRequest $request)
    {
        try {
            $token = $this->authUserAction->handler($request->all());

            $response = [
                'meta' => [
                    "success" => true,
                    "errors"  => [],
                    "data"    => [
                        'token'             => $token->accessToken,
                        'minutes_to_expire' => $token->token->expires_at->diffInMinutes(now()),
                    ],
                ],
            ];

            return response($response, Response::HTTP_OK);

        } catch (\Exception $exception) {
            $response = [
                'meta' => [
                    "success" => false,
                    "errors"  => [
                        $exception->getMessage(),
                    ],
                ],
            ];

            return response($response, $exception->getCode());
        }
    }
}
