<?php

namespace App\Http\Controllers;

use App\Http\Base\Controllers\Controller;
use App\Helper\ResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use http\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request);
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }

    /**
     * @return mixed
     */
    public function userProfile()
    {
        return $this->authService->userProfile();
    }

    /**
     * @return mixed
     */
    public function userLogout()
    {
        return $this->authService->userLogout();
    }
}
