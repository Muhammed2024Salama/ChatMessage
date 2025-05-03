<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interface\AuthInterface;

class AuthService
{
    /**
     * @var AuthInterface
     */
    protected $authRepository;

    /**
     * @param AuthInterface $authRepository
     */
    public function __construct(AuthInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        return $this->authRepository->register($request);
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        return $this->authRepository->login($request);
    }

    /**
     * @return mixed
     */
    public function userProfile()
    {
        return $this->authRepository->userProfile();
    }

    /**
     * @return mixed
     */
    public function userLogout()
    {
        return $this->authRepository->userLogout();
    }
}
