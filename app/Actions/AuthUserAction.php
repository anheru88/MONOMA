<?php

namespace App\Actions;

use App\Actions\Contracts\AuthUserActionInterface;
use App\Exceptions\LoginException;
use App\Repositories\Contracts\UserRepositoryInterface;
use Laravel\Passport\PersonalAccessTokenResult;
use Symfony\Component\HttpFoundation\Response;


class AuthUserAction implements AuthUserActionInterface
{
    private UserRepositoryInterface $userRepository;

    /**
     * @param  UserRepositoryInterface  $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param  array  $data
     * @return PersonalAccessTokenResult
     * @throws LoginException
     */
    public function handler(array $data): PersonalAccessTokenResult
    {
        $user = $this->userRepository->findByUsername($data['username']);

        if (!password_verify($data['password'], $user->password)) {
            throw new LoginException(
                'Password incorrect for: '.$data['username'],
                Response::HTTP_BAD_REQUEST
            );
        }

        if (!$user->is_active) {
            throw new LoginException('User is inactive', Response::HTTP_UNAUTHORIZED);
        }

        return $this->userRepository->createToken($user);
    }
}
