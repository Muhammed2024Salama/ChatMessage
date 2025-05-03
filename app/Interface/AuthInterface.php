<?php

namespace App\Interface;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

interface AuthInterface
{
    /**
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request);

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request);

    /**
     * @return mixed
     */
    public function userProfile();

    /**
     * @return mixed
     */
    public function userLogout();
}
