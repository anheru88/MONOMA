<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationException;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserApiAuthenticatedMiddleware
{
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $this->authenticate($request, ['api']);
        } catch (AuthenticationException $exception) {
            $response = [
                'meta' => [
                    'success' => false,
                    'errors' => [
                        $exception->getMessage(),
                    ],
                ],
            ];

            return response($response, $exception->getCode());
        }

        return $next($request);
    }

    /**
     * @throws AuthenticationException
     */
    private function authenticate(Request $request, $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated();
    }

    /**
     * @throws AuthenticationException
     */
    private function unauthenticated()
    {
        throw new AuthenticationException(
            'Token Expired',
            Response::HTTP_UNAUTHORIZED
        );
    }
}
